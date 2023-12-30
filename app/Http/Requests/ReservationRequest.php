<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'events.*.id' => ['required', 'exists:App\Models\Event,id'],
            'events.*.seats.*.type' => ['required', Rule::in(['standard', 'premium', 'gold'])],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'events.*.id.required' => 'The event field is required.',
            'events.*.id.exists' => 'The event not exists.',
            'events.*.seats.*.required' => 'The type seat is required.',
        ];
    }
}
