<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportDetailResource extends JsonResource
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
            'description' => $this->description,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => $this->status?->value,
            'priority' => $this->priority?->value,
            'region' => $this->region?->only(['id', 'name', 'code']),
            'category' => $this->category?->only(['id', 'name', 'slug']),
            'images' => $this->images->map(fn ($image) => [
                'path' => $image->path,
                'kind' => $image->kind,
            ]),
            'histories' => $this->statusHistories->map(fn ($history) => [
                'from' => $history->from_status?->value,
                'to' => $history->to_status?->value,
                'at' => $history->created_at,
            ]),
            'created_at' => $this->created_at,
        ];
    }
}
