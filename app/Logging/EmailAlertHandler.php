<?php

namespace App\Logging;

use App\Mail\ErrorLogAlertMail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;

class EmailAlertHandler extends AbstractProcessingHandler
{
    /**
     * Prevents recursive mail-failure logging loops within the same process.
     */
    private static bool $isSending = false;

    /**
     * Fallback in-memory deduplication if file cache is unavailable.
     *
     * @var array<string, bool>
     */
    private static array $seenInProcess = [];

    public function __construct(int|string|Level $level = Level::Error, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    protected function write(LogRecord $record): void
    {
        if (self::$isSending || !$this->shouldSendAlert()) {
            return;
        }

        $recipient = (string) config('logging.error_alert.to', '');
        if ($recipient === '') {
            return;
        }

        $dedupKey = $this->buildDedupKey($record);
        if (!$this->acquireDailySendSlot($dedupKey)) {
            return;
        }

        $alertData = $this->extractAlertData($record);

        if (!app()->runningInConsole()) {
            app()->terminating(function () use ($recipient, $alertData): void {
                $this->sendSafely($recipient, $alertData);
            });

            return;
        }

        $this->sendSafely($recipient, $alertData);
    }

    private function shouldSendAlert(): bool
    {
        if (!config('logging.error_alert.enabled', false)) {
            return false;
        }

        if (config('logging.error_alert.only_production', true) && !app()->isProduction()) {
            return false;
        }

        return true;
    }

    private function buildDedupKey(LogRecord $record): string
    {
        $exception = $record->context['exception'] ?? null;

        if ($exception instanceof \Throwable) {
            $fingerprint = implode('|', [
                $exception::class,
                $exception->getFile(),
                (string) $exception->getLine(),
                $this->normalizeText($exception->getMessage()),
            ]);
        } else {
            $fingerprint = implode('|', [
                $record->level->getName(),
                $this->normalizeText($record->message),
            ]);
        }

        return 'error_alert:' . now()->format('Y-m-d') . ':' . sha1($fingerprint);
    }

    private function acquireDailySendSlot(string $dedupKey): bool
    {
        if (isset(self::$seenInProcess[$dedupKey])) {
            return false;
        }
        self::$seenInProcess[$dedupKey] = true;

        try {
            return Cache::store('file')->add($dedupKey, true, now()->endOfDay());
        } catch (\Throwable) {
            return true;
        }
    }

    /**
     * @return array<string, string>
     */
    private function extractAlertData(LogRecord $record): array
    {
        $exception = $record->context['exception'] ?? null;
        $location = '';
        $trace = '';

        if ($exception instanceof \Throwable) {
            $location = $exception->getFile() . ':' . $exception->getLine();
            $traceLines = array_slice(explode("\n", $exception->getTraceAsString()), 0, 25);
            $trace = mb_substr(implode("\n", $traceLines), 0, 3000);
        } elseif (!empty($record->context)) {
            $encoded = json_encode($record->context, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            if ($encoded !== false) {
                $trace = mb_substr($encoded, 0, 2000);
            }
        }

        $method = 'CLI';
        $url = 'Artisan / Console';
        $ip = '127.0.0.1';
        $userInfo = 'System / Console';

        if (!app()->runningInConsole() && app()->bound('request')) {
            try {
                $request = request();
                $method = $request->method();
                $url = $request->fullUrl();
                $ip = (string) ($request->ip() ?? '-');
                $user = $request->user();
                $userInfo = $user
                    ? trim(($user->name ?? 'User') . ' (ID: ' . $user->id . ($user->email ? ', ' . $user->email : '') . ')')
                    : 'Guest (Belum Login)';
            } catch (\Throwable) {
                // Keep safe defaults if request context is partially unavailable.
            }
        }

        $appUrl = rtrim((string) config('app.url', ''), '/');
        $logViewerPath = ltrim((string) config('log-viewer.route_path', 'log-viewer'), '/');

        return [
            'app_name' => (string) config('app.name', 'CalonASN'),
            'environment' => (string) app()->environment(),
            'level' => $record->level->getName(),
            'timestamp' => $record->datetime->format('Y-m-d H:i:s T'),
            'method' => $method,
            'url' => $url,
            'ip' => $ip,
            'user_info' => $userInfo,
            'location' => $location,
            'message' => $record->message,
            'trace' => $trace,
            'log_viewer_url' => $appUrl !== '' ? "{$appUrl}/{$logViewerPath}" : '',
        ];
    }

    /**
     * @param array<string, string> $alertData
     */
    private function sendSafely(string $recipient, array $alertData): void
    {
        if (self::$isSending) {
            return;
        }

        self::$isSending = true;
        try {
            Mail::to($recipient)->send(new ErrorLogAlertMail($alertData));
        } catch (\Throwable) {
            // Swallow mail errors so SMTP outage cannot cause infinite logging recursion.
        } finally {
            self::$isSending = false;
        }
    }

    private function normalizeText(string $text): string
    {
        return mb_substr((string) preg_replace('/\s+/', ' ', trim($text)), 0, 200);
    }
}
