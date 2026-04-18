<?php

namespace App\Services;

use App\Models\Participant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PDFService
{
    public function __construct(private QRCodeService $qrService) {}

    /**
     * Generate PDF ticket untuk participant
     * 
     * @param Participant $participant
     * @return string Storage path ke PDF
     * @throws \Exception
     */
    public function generate(Participant $participant): string
    {
        try {
            // Pastikan QR Code sudah ada
            if (!$participant->qr_code_path) {
                throw new \Exception('QR Code belum di-generate untuk participant ini');
            }

            // Path ke QR Code file
            $qrPath = public_path('storage/' . $participant->qr_code_path);

            if (!file_exists($qrPath)) {
                throw new \Exception('QR Code file tidak ditemukan: ' . $qrPath);
            }

            $filename = 'tickets/' . $participant->ticket_code . '.pdf';

            // Pastikan direktori ada
            $directory = storage_path('app/public/tickets');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Generate PDF
            $pdf = Pdf::loadView('pdf.ticket', [
                'participant' => $participant,
                'qrPath'      => $qrPath,
            ])->setPaper('a5', 'portrait');

            // Simpan ke storage
            Storage::disk('public')->put($filename, $pdf->output());

            return $filename;

        } catch (\Exception $e) {
            \Log::error('Error generating PDF:', [
                'participant_id' => $participant->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get full file system path dari storage path
     * 
     * @param string $storagePath
     * @return string
     */
    public function path(string $storagePath): string
    {
        return storage_path('app/public/' . $storagePath);
    }

    /**
     * Get public URL dari storage path
     * 
     * @param string $storagePath
     * @return string
     */
    public function url(string $storagePath): string
    {
        return Storage::disk('public')->url($storagePath);
    }
}