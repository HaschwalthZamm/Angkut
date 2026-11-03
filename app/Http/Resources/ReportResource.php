<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tracking_code' => $this->tracking_code,
            'title' => $this->title,
            'status' => $this->status?->value,
            'priority' => $this->priority?->value,
            'region' => $this->region?->name,
            'category' => $this->category?->name,
            'created_at' => $this->created_at,
        ];
    }
}
