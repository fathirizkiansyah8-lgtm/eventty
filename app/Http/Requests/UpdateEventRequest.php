<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'capacity' => 'nullable|integer|min:1',
            'status' => 'nullable|in:draft,published,ongoing,completed,cancelled',
            'is_paid' => 'nullable|boolean',
            'price' => 'nullable|numeric|min:0',
            'thumbnail_image_path' => 'nullable|string',
            'certificate_template_path' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'capacity.min' => 'Event capacity must be at least 1',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be 0 or greater',
        ];
    }
}
