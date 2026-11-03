<?php

namespace App\Services\Notification\Channels;

use App\Jobs\SendWhatsappNotification;
use App\Models\User;
use App\Services\Notification\Contracts\Notifier;

class WhatsappNotifier implements Notifier
{
    public function send(User $user, array $payload): void
    {
        if (! $user->phone) {
            return;
        }

        SendWhatsappNotification::dispatch($user->phone, $payload['body'] ?? '');
    }
}
