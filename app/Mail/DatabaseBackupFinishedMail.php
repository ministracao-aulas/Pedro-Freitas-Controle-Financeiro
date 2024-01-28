<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DatabaseBackupFinishedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public bool $success,
        public ?string $filePath = null,
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->success ? 'Cópia do arquivo de backup do banco' : 'Falha ao gerar o backup',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: null,
            markdown: 'email.database-backup.message',
            with: [
                'success' => $this->success,
                'filePath' => $this->filePath && is_file($this->filePath) ? $this->filePath : null,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (!$this->success || !$this->filePath || !is_file($this->filePath)) {
            return [];
        }

        $getMimeType = function (string $filePath) {
            if (!filled($filePath)) {
                return null;
            } $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $filePath);
            finfo_close($finfo);

            return $mime;
        };

        $fileName = pathinfo($this->filePath, PATHINFO_BASENAME);
        $mimeType = $getMimeType($this->filePath);

        $attach = \Illuminate\Mail\Mailables\Attachment::fromData(fn () => $this->filePath, $fileName);

        if ($mimeType) {
            $attach = $attach->withMime($mimeType);
        }

        return [
            $attach,
        ];
    }
}
