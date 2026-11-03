<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendWhatsappNotification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $phone,
        public string $message,
    ) {}

    public function handle(): void
    {
        Log::info('WhatsApp stub', [
            'phone' => $this->phone,
            'message' => $this->message,
        ]);
    }
}
