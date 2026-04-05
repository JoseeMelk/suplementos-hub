<?php
// app/Services/ImageService.php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    const WIDTH   = 800;
    const HEIGHT  = 800;
    const QUALITY = 85;
    const DISK    = 'public';
    const FOLDER  = 'products';

    public function processFromUpload(UploadedFile $file): ?string
    {
        try {
            return $this->process(Image::read($file->getRealPath()));
        } catch (\Exception $e) {
            Log::warning('ImageService: error procesando upload: ' . $e->getMessage());
            return null;
        }
    }

    public function processFromUrl(string $url): ?string
    {
        try {
            $content = file_get_contents($url);
            if (!$content) return null;

            return $this->process(Image::read($content));
        } catch (\Exception $e) {
            Log::warning('ImageService: error procesando URL: ' . $url . ' — ' . $e->getMessage());
            return null;
        }
    }

    private function process($image): string
    {
        $filename = self::FOLDER . '/' . Str::uuid() . '.webp';

        $encoded = $image->cover(self::WIDTH, self::HEIGHT)
            ->toWebp(self::QUALITY)
            ->toString();

        Storage::disk(self::DISK)->put($filename, $encoded);

        return $filename;
    }
}
