<?php

namespace App\Services\Notification\Channels;

use App\Models\User;
use App\Services\Notification\Contracts\Notifier;
use Illuminate\Support\Facades\Notification;

class EmailNotifier implements Notifier
{
    public function send(User $user, array $payload): void
    {
        if (! $user->email || empty($payload['notification'])) {
            return;
        }

        Notification::send($user, $payload['notification']);
    }
}
