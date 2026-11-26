<?php

namespace App\Logging;

use Monolog\Logger;

class CreateEmailAlertLogger
{
    /**
     * Create a custom Monolog instance for error email notifications.
     *
     * @param array<string, mixed> $config
     */
    public function __invoke(array $config): Logger
    {
        $level = $config['level'] ?? 'error';

        return new Logger('email_alert', [
            new EmailAlertHandler($level),
        ]);
    }
}
