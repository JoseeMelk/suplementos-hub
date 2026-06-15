<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TrackingNumberService
{
    /**
     * Genera un código de seguimiento único de exactamente 10 caracteres.
     * Ejemplo de salida: TCK-A8B9D2 o ABC123XYZ4
     */
    public function generateTrackingNumber(): string
    {
        do {
            // Opción A: Totalmente alfanumérico en mayúsculas (Ej: 8K7M2N1P9Q)
            $trackingNumber = strtoupper(Str::random(10));
            
            // Opción B: Con prefijo fijo (Ej: TCK-8K7M2N -> total 10 caracteres)
            // $trackingNumber = 'TCK-' . strtoupper(Str::random(6));

        } while (!$this->validateTrackingNumber($trackingNumber));

        return $trackingNumber;
    }

    /**
     * Valida que el código sea único en la tabla de tickets.
     * Retorna TRUE si el código está disponible (es válido para usar).
     */
    public function validateTrackingNumber($trackingNumber): bool
    {
        // Verifica si ya existe en la base de datos
        $exists = DB::table('tickets')
            ->where('tracking_number', $trackingNumber)
            ->exists();

        // Retorna verdadero si NO existe (está libre)
        return !$exists;
    }
}
