<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileUploadService
{
    /**
     * Allowed file types for different upload types
     */
    const ALLOWED_IMAGE_TYPES = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    const ALLOWED_DOCUMENT_TYPES = ['pdf', 'doc', 'docx'];
    
    /**
     * Maximum file sizes (in bytes)
     */
    const MAX_IMAGE_SIZE = 2048 * 1024; // 2MB
    const MAX_DOCUMENT_SIZE = 5120 * 1024; // 5MB
    
    /**
     * Image dimensions
     */
    const AVATAR_SIZE = 300;
    const BANNER_WIDTH = 800;
    const BANNER_HEIGHT = 400;

    /**
     * Upload event banner
     */
    public function uploadEventBanner(UploadedFile $file, ?string $oldPath = null): string
    {
        $this->validateImageFile($file);
        
        // Delete old banner if exists
        if ($oldPath) {
            $this->deleteFile($oldPath);
        }
        
        // Generate unique filename
        $filename = $this->generateFilename($file, 'banner');
        
        // Resize and optimize image
        $processedImage = $this->resizeImage($file, self::BANNER_WIDTH, self::BANNER_HEIGHT);
        
        // Store processed image
        $path = 'event-banners/' . $filename;
        Storage::disk('public')->put($path, $processedImage);
        
        return $path;
    }

    /**
     * Upload user avatar
     */
    public function uploadUserAvatar(UploadedFile $file, ?string $oldPath = null): string
    {
        $this->validateImageFile($file);
        
        // Delete old avatar if exists
        if ($oldPath) {
            $this->deleteFile($oldPath);
        }
        
        // Generate unique filename
        $filename = $this->generateFilename($file, 'avatar');
        
        // Resize to square avatar
        $processedImage = $this->resizeImage($file, self::AVATAR_SIZE, self::AVATAR_SIZE, true);
        
        // Store processed image
        $path = 'avatars/' . $filename;
        Storage::disk('public')->put($path, $processedImage);
        
        return $path;
    }

    /**
     * Upload certificate file
     */
    public function uploadCertificateFile(UploadedFile $file): string
    {
        $this->validateDocumentFile($file);
        
        // Generate unique filename
        $filename = $this->generateFilename($file, 'certificate');
        
        // Store file
        $path = 'certificates/' . $filename;
        $file->storeAs('certificates', $filename, 'public');
        
        return $path;
    }

    /**
     * Delete file from storage
     */
    public function deleteFile(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        
        return true;
    }

    /**
     * Get file URL
     */
    public function getFileUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }

    /**
     * Check if file exists
     */
    public function fileExists(string $path): bool
    {
        return Storage::disk('public')->exists($path);
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSize(string $path): ?string
    {
        if (!$this->fileExists($path)) {
            return null;
        }
        
        $bytes = Storage::disk('public')->size($path);
        return $this->formatBytes($bytes);
    }

    /**
     * Validate image file
     */
    private function validateImageFile(UploadedFile $file): void
    {
        // Check if file is valid
        if (!$file->isValid()) {
            throw new \InvalidArgumentException('File upload failed.');
        }

        // Check file size
        if ($file->getSize() > self::MAX_IMAGE_SIZE) {
            throw new \InvalidArgumentException('File size must be less than 2MB.');
        }

        // Check file type
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, self::ALLOWED_IMAGE_TYPES)) {
            throw new \InvalidArgumentException('File must be an image (jpg, jpeg, png, gif, webp).');
        }

        // Check MIME type
        $mimeType = $file->getMimeType();
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($mimeType, $allowedMimes)) {
            throw new \InvalidArgumentException('Invalid file format.');
        }
    }

    /**
     * Validate document file
     */
    private function validateDocumentFile(UploadedFile $file): void
    {
        // Check if file is valid
        if (!$file->isValid()) {
            throw new \InvalidArgumentException('File upload failed.');
        }

        // Check file size
        if ($file->getSize() > self::MAX_DOCUMENT_SIZE) {
            throw new \InvalidArgumentException('File size must be less than 5MB.');
        }

        // Check file type
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, self::ALLOWED_DOCUMENT_TYPES)) {
            throw new \InvalidArgumentException('File must be a document (pdf, doc, docx).');
        }
    }

    /**
     * Generate unique filename
     */
    private function generateFilename(UploadedFile $file, string $prefix): string
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('Y-m-d-H-i-s');
        $random = Str::random(8);
        
        return "{$prefix}-{$timestamp}-{$random}.{$extension}";
    }

    /**
     * Resize image (simplified version without Intervention Image)
     */
    private function resizeImage(UploadedFile $file, int $width, int $height, bool $crop = false): string
    {
        // For now, just return the original file content
        // In production, implement image resizing with GD or ImageMagick
        return file_get_contents($file->getPathname());
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get file mime type
     */
    public function getFileMimeType(string $path): ?string
    {
        if (!$this->fileExists($path)) {
            return null;
        }
        
        $fullPath = Storage::disk('public')->path($path);
        return mime_content_type($fullPath);
    }

    /**
     * Create directory if not exists
     */
    public function ensureDirectoryExists(string $directory): void
    {
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
    }
}