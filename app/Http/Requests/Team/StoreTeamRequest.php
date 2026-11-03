<?php

namespace App\Http\Requests\Team;

use App\Enums\TeamStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', \App\Models\Team::class) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'region_id' => ['required', 'exists:regions,id'],
            'status' => ['nullable', Rule::enum(TeamStatus::class)],
            'description' => ['nullable', 'string'],
        ];
    }
}
