<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:' . $this->getMaxFileSize(),
                'mimes:' . $this->getAllowedMimes(),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file.required' => 'File harus dipilih.',
            'file.file' => 'File yang diupload tidak valid.',
            'file.max' => 'Ukuran file maksimal ' . ($this->getMaxFileSize() / 1024) . 'MB.',
            'file.mimes' => 'Format file harus: ' . str_replace(',', ', ', $this->getAllowedMimes()) . '.',
        ];
    }

    /**
     * Get maximum file size based on upload type
     */
    protected function getMaxFileSize(): int
    {
        return match ($this->getUploadType()) {
            'avatar' => 2048, // 2MB
            'banner' => 2048, // 2MB
            'certificate' => 5120, // 5MB
            default => 2048, // 2MB
        };
    }

    /**
     * Get allowed MIME types based on upload type
     */
    protected function getAllowedMimes(): string
    {
        return match ($this->getUploadType()) {
            'avatar' => 'jpeg,png,jpg,gif,webp',
            'banner' => 'jpeg,png,jpg,gif,webp',
            'certificate' => 'pdf,doc,docx',
            default => 'jpeg,png,jpg,gif,webp',
        };
    }

    /**
     * Get upload type from request
     */
    protected function getUploadType(): string
    {
        return $this->input('type', 'image');
    }
}
