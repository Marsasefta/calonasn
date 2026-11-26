<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ErrorLogAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public array $alertData)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $appName = $this->alertData['app_name'] ?? config('app.name', 'CalonASN');
        $env = strtoupper((string) ($this->alertData['environment'] ?? 'production'));
        $level = strtoupper((string) ($this->alertData['level'] ?? 'ERROR'));
        $shortMessage = Str::limit(
            preg_replace('/\s+/', ' ', (string) ($this->alertData['message'] ?? 'Unknown error')),
            85
        );

        return new Envelope(
            subject: "[{$appName} {$env} {$level}] {$shortMessage}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.error-log-alert',
        );
    }
}
