<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\FileExtension;

class ImageService
{
    const WIDTH   = 800;
    const HEIGHT  = 800;
    const QUALITY = 85;
    const DISK    = 'public';
    const FOLDER  = 'products';

    protected ImageManager $manager;

    public function __construct()
    {
        // Driver GD (puedes cambiar a Imagick si quieres)
        $this->manager = new ImageManager(new Driver());
    }

    public function processFromUpload(UploadedFile $file): ?string
    {
        try {
            $image = $this->manager->decode($file->getRealPath());
            return $this->process($image);
        } catch (\Throwable $e) {
            Log::warning('ImageService upload error: ' . $e->getMessage());
            return null;
        }
    }

    public function processFromUrl(string $url): ?string
    {
        try {
            $content = @file_get_contents($url);

            if (!$content) {
                return null;
            }

            $image = $this->manager->decode($content);
            return $this->process($image);
        } catch (\Throwable $e) {
            Log::warning("ImageService URL error: {$url} — " . $e->getMessage());
            return null;
        }
    }

    private function process($image): string
{
    $filename = self::FOLDER . '/' . Str::uuid() . '.webp';

    // 1. Redimensionar
    $image->cover(self::WIDTH, self::HEIGHT);

    // 2. Codificar (Basado en el link que pasaste)
    // En v4, toWebp() devuelve un objeto de tipo EncodedImage
    $encoded = $image->encodeUsingFileExtension(FileExtension::WEBP, quality: self::QUALITY);

    // 3. Guardar en Storage
    // IMPORTANTE: En v4 debes usar ->toString() para obtener el contenido binario
    Storage::disk(self::DISK)->put($filename, $encoded->toString());

    return $filename;
}

}
