<?php

namespace App\Services\Notification;

use App\Enums\NotificationChannel;
use App\Models\User;
use App\Services\Notification\Channels\DatabaseNotifier;
use App\Services\Notification\Channels\EmailNotifier;
use App\Services\Notification\Channels\WhatsappNotifier;
use App\Services\Notification\Contracts\Notifier;

class NotificationService
{
    /**
     * @param  array<string, mixed>  $payload
     * @param  list<NotificationChannel>  $channels
     */
    public function notify(User $user, array $payload, array $channels = [NotificationChannel::Database]): void
    {
        foreach ($channels as $channel) {
            $this->driver($channel)->send($user, $payload);
        }
    }

    private function driver(NotificationChannel $channel): Notifier
    {
        return match ($channel) {
            NotificationChannel::Database => app(DatabaseNotifier::class),
            NotificationChannel::Email => app(EmailNotifier::class),
            NotificationChannel::Whatsapp => app(WhatsappNotifier::class),
        };
    }
}
