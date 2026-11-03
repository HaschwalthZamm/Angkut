<?php

namespace App\Http\Requests\Report;

use App\Enums\ReportPriority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $guestRules = $this->user() ? [] : [
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_phone' => ['required', 'string', 'max:20'],
        ];

        return [
            ...$guestRules,
            'region_id' => ['required', 'exists:regions,id'],
            'report_category_id' => ['required', 'exists:report_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'address' => ['required', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'priority' => ['nullable', Rule::enum(ReportPriority::class)],
            'images' => ['nullable', 'array', 'max:'.config('angkut.max_foto', 5)],
            'images.*' => ['image', 'max:4096'],
        ];
    }
}
