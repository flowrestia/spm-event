<?php
// app/Services/QRCodeService.php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class QRCodeService
{
    /**
     * Generate QR Code image untuk ticket code
     * 
     * @param string $ticketCode - Ticket code yang akan di-encode
     * @return string Storage path ke QR Code image
     * @throws \Exception
     */
    public function generate(string $ticketCode): string
    {
        try {
            $filename  = 'qrcodes/' . $ticketCode . '.png';
            $directory = storage_path('app/public/qrcodes');

            // Pastikan direktori ada
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Generate QR Code
            $qrImage = QrCode::format('svg')
                ->size(400)
                ->margin(2)
                ->errorCorrection('H')
                ->generate($ticketCode);

            // Simpan ke storage
            Storage::disk('public')->put($filename, $qrImage);

            \Log::info('QR Code berhasil di-generate', ['ticket_code' => $ticketCode]);

            return $filename;

        } catch (\Exception $e) {
            \Log::error('Error generating QR Code:', [
                'ticket_code' => $ticketCode,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get public URL untuk QR Code
     * 
     * @param string $path - Storage path
     * @return string Public URL
     */
    public function url(string $path): string
    {
        return Storage::disk('public')->url($path);
    }
}