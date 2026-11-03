<?php

namespace App\Services\Notification\Channels;

use App\Models\User;
use App\Services\Notification\Contracts\Notifier;

class DatabaseNotifier implements Notifier
{
    public function send(User $user, array $payload): void
    {
        $user->appNotifications()->create([
            'type' => $payload['type'] ?? 'report',
            'title' => $payload['title'] ?? 'Notifikasi',
            'body' => $payload['body'] ?? '',
            'data' => $payload['data'] ?? [],
        ]);
    }
}
