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
    const WIDTH   = 900;
    const HEIGHT  = 1150;
    const QUALITY = 95;
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

        // 1. Escalar sin recortar (mantiene proporciones)
        $image->scaleDown(
            width: self::WIDTH,
            height: self::HEIGHT
        );

        // Obtener las dimensiones actuales de la imagen ya escalada
        $currentWidth = $image->width();
        $currentHeight = $image->height();

        // 2. Determinar el tamaño del canvas dinámicamente
        // Si es menor a 800x800, el canvas se ajusta exactamente a la imagen (cero espacio blanco)
        if ($currentWidth < 800 || $currentHeight < 800) {
            $canvasWidth = $currentWidth;
            $canvasHeight = $currentHeight;
        } else {
            // Si es grande, mantiene tus dimensiones máximas estándar (900x1200)
            $canvasWidth = self::WIDTH;
            $canvasHeight = self::HEIGHT;
        }

        // 3. Agregar canvas/fondo con las medidas calculadas
        $image->resizeCanvas(
            $canvasWidth,
            $canvasHeight,
            '#ffffff',
            'center'
        );

        // 4. Codificar
        $encoded = $image->encodeUsingFileExtension(
            FileExtension::WEBP,
            quality: self::QUALITY
        );

        // 5. Guardar
        Storage::disk(self::DISK)->put(
            $filename,
            $encoded->toString()
        );

        return $filename;
    }


    public function delete(string $path): void
    {
        Storage::disk(self::DISK)->delete($path);
    }
}
