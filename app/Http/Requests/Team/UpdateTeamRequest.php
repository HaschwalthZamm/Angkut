<?php

namespace App\Http\Requests\Team;

use App\Enums\TeamStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('team')) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'region_id' => ['sometimes', 'exists:regions,id'],
            'status' => ['sometimes', Rule::enum(TeamStatus::class)],
            'description' => ['nullable', 'string'],
        ];
    }
}
