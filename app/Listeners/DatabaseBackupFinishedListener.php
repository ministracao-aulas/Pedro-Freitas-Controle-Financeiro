<?php

namespace App\Listeners;

use App\Events\DatabaseBackupFinished;
use App\Mail\DatabaseBackupFinishedMail;
use Illuminate\Support\Facades\Mail;

class DatabaseBackupFinishedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DatabaseBackupFinished $event): void
    {
        $this->sendByEmail($event);
    }

    public function sendByEmail(DatabaseBackupFinished $event): void
    {
        $mailTo = array_filter(
            (array) config('database-backup.notifiers.email'),
            fn ($item) => filter_var($item, FILTER_VALIDATE_EMAIL),
        );

        if (!$mailTo) {
            return;
        }

        Mail::to($mailTo)
            ->send(
                new DatabaseBackupFinishedMail(
                    $event->success,
                    $event->filePath
                )
            );
    }
}
