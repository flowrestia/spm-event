<?php

namespace App\Mail;

use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * 
     * @param Participant $participant - Data peserta
     * @param string $pdfPath - Alamat PDF di file system
     */
    public function __construct(
        public Participant $participant,
        public string $pdfPath
    ) {
        // Set queue untuk background processing
        $this->queue = 'default';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎟️ Tiket Anda - Sekolah Pasar Modal Financial Glow Up 2026',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        // Periksa apakah file PDF ada sebelum attach
        if (!file_exists($this->pdfPath)) {
            \Log::warning('PDF tidak ditemukan untuk participant: ' . $this->participant->id, [
                'path' => $this->pdfPath
            ]);
            return [];
        }

        return [
            Attachment::fromPath($this->pdfPath)
                ->as($this->participant->ticket_code . '-Tiket.pdf')
                ->withMime('application/pdf'),
        ];
    }
}