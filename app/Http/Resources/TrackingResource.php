<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackingResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tracking_code' => $this->tracking_code,
            'status' => $this->status?->value,
            'status_label' => $this->status?->label(),
            'title' => $this->title,
            'region' => $this->region?->name,
            'updated_at' => $this->updated_at,
        ];
    }
}
