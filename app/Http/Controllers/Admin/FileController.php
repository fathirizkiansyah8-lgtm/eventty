<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Upload temporary file (for previews)
     */
    public function uploadTemp(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'type' => 'required|in:image,document',
        ]);

        try {
            $file = $request->file('file');
            $type = $request->input('type');

            if ($type === 'image') {
                // Validate as image
                $request->validate([
                    'file' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                ]);

                $path = $this->fileUploadService->uploadEventBanner($file);
            } else {
                // Validate as document
                $request->validate([
                    'file' => 'mimes:pdf,doc,docx|max:5120',
                ]);

                $path = $this->fileUploadService->uploadCertificateFile($file);
            }

            return response()->json([
                'success' => true,
                'message' => 'File berhasil diupload.',
                'path' => $path,
                'url' => $this->fileUploadService->getFileUrl($path),
                'size' => $this->fileUploadService->getFileSize($path),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload file: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Delete file
     */
    public function delete(Request $request): JsonResponse
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        try {
            $path = $request->input('path');
            $deleted = $this->fileUploadService->deleteFile($path);

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'File berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan atau gagal dihapus.'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get file info
     */
    public function info(Request $request): JsonResponse
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = $request->input('path');

        if (!$this->fileUploadService->fileExists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'path' => $path,
                'url' => $this->fileUploadService->getFileUrl($path),
                'size' => $this->fileUploadService->getFileSize($path),
                'mime_type' => $this->fileUploadService->getFileMimeType($path),
                'exists' => true,
            ]
        ]);
    }

    /**
     * List files in directory
     */
    public function listFiles(Request $request): JsonResponse
    {
        $directory = $request->input('directory', '');
        $type = $request->input('type', 'all'); // all, images, documents

        try {
            $files = Storage::disk('public')->files($directory);
            $fileList = [];

            foreach ($files as $file) {
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $fileType = $this->getFileType($extension);

                if ($type !== 'all' && $fileType !== $type) {
                    continue;
                }

                $fileList[] = [
                    'path' => $file,
                    'name' => basename($file),
                    'url' => $this->fileUploadService->getFileUrl($file),
                    'size' => $this->fileUploadService->getFileSize($file),
                    'type' => $fileType,
                    'extension' => $extension,
                    'modified' => date('Y-m-d H:i:s', Storage::disk('public')->lastModified($file)),
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $fileList,
                'directory' => $directory,
                'total' => count($fileList),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get file type by extension
     */
    private function getFileType(string $extension): string
    {
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $documentTypes = ['pdf', 'doc', 'docx'];

        if (in_array(strtolower($extension), $imageTypes)) {
            return 'image';
        } elseif (in_array(strtolower($extension), $documentTypes)) {
            return 'document';
        }

        return 'other';
    }
}
