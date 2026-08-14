<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'capacity' => 'required|integer|min:1',
            'status' => 'nullable|in:draft,published,ongoing,completed,cancelled',
            'is_paid' => 'nullable|boolean',
            'price' => 'nullable|numeric|min:0',
            'thumbnail_image_path' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Event title is required',
            'description.required' => 'Event description is required',
            'category.required' => 'Event category is required',
            'location.required' => 'Event location is required',
            'start_date.required' => 'Start date is required',
            'start_date.after' => 'Start date must be in the future',
            'end_date.required' => 'End date is required',
            'end_date.after_or_equal' => 'End date must be after or equal to start date',
            'start_time.required' => 'Start time is required',
            'end_time.required' => 'End time is required',
            'end_time.after' => 'End time must be after start time',
            'capacity.required' => 'Event capacity is required',
            'capacity.min' => 'Event capacity must be at least 1',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be 0 or greater',
        ];
    }
}
