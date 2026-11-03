<?php

namespace App\Http\Requests\Task;

use App\Enums\ReportStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('updateStatus', $this->route('report')) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([
                ReportStatus::OnProgress->value,
                ReportStatus::Completed->value,
            ])],
            'notes' => ['nullable', 'string', 'max:1000'],
            'images' => ['nullable', 'array', 'max:'.config('angkut.max_foto', 5)],
            'images.*' => ['image', 'max:4096'],
        ];
    }
}
