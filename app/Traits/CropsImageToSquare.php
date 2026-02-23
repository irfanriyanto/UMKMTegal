<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait CropsImageToSquare
{
    /**
     * Crop and store an uploaded image as a square (1:1 ratio)
     * Uses PHP GD library for image processing
     *
     * @param UploadedFile $file The uploaded file
     * @param string $directory The storage directory
     * @param int $size The target size in pixels (default 800x800)
     * @return string The stored file path
     */
    protected function cropAndStoreSquare(UploadedFile $file, string $directory, int $size = 800): string
    {
        $sourcePath = $file->getRealPath();
        $mimeType = $file->getMimeType();
        
        // Create image resource based on mime type
        $sourceImage = $this->createImageFromFile($sourcePath, $mimeType);
        
        if (!$sourceImage) {
            // Fallback to simple store if GD fails
            return $file->store($directory, 'public');
        }
        
        // Get current dimensions
        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);
        
        // Determine the size of the square crop (use the smaller dimension)
        $cropSize = min($width, $height);
        
        // Calculate crop position (center crop)
        $x = (int) (($width - $cropSize) / 2);
        $y = (int) (($height - $cropSize) / 2);
        
        // Create destination image
        $destImage = imagecreatetruecolor($size, $size);
        
        // Preserve transparency for PNG
        if ($mimeType === 'image/png') {
            imagealphablending($destImage, false);
            imagesavealpha($destImage, true);
            $transparent = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
            imagefilledrectangle($destImage, 0, 0, $size, $size, $transparent);
        }
        
        // Crop and resize
        imagecopyresampled(
            $destImage,
            $sourceImage,
            0, 0,           // Destination x, y
            $x, $y,         // Source x, y (center crop)
            $size, $size,   // Destination width, height
            $cropSize, $cropSize // Source width, height
        );
        
        // Generate filename
        $filename = uniqid() . '.jpg';
        $path = $directory . '/' . $filename;
        $fullPath = storage_path('app/public/' . $path);
        
        // Ensure directory exists
        $dirPath = dirname($fullPath);
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
        }
        
        // Save as JPEG for consistency
        imagejpeg($destImage, $fullPath, 85);
        
        // Free memory
        imagedestroy($sourceImage);
        imagedestroy($destImage);
        
        return $path;
    }

    /**
     * Create GD image resource from file with fallback handling
     */
    private function createImageFromFile(string $path, string $mimeType): \GdImage|false
    {
        try {
            return match ($mimeType) {
                'image/jpeg', 'image/jpg' => imagecreatefromjpeg($path),
                'image/png' => imagecreatefrompng($path),
                'image/gif' => imagecreatefromgif($path),
                'image/webp' => function_exists('imagecreatefromwebp') ? imagecreatefromwebp($path) : $this->createImageFallback($path),
                default => $this->createImageFallback($path),
            };
        } catch (\Throwable $e) {
            return $this->createImageFallback($path);
        }
    }

    /**
     * Fallback method to create image using imagecreatefromstring
     */
    private function createImageFallback(string $path): \GdImage|false
    {
        $contents = file_get_contents($path);
        if ($contents === false) {
            return false;
        }
        return imagecreatefromstring($contents);
    }
}
