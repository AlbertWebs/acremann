<?php

namespace App\Mail;

use App\Models\SiteVisitBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SiteVisitBookingStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public SiteVisitBooking $booking) {}

    public function envelope(): Envelope
    {
        $subject = match ($this->booking->status->value) {
            'confirmed' => 'Your site visit is confirmed',
            'cancelled' => 'Update on your site visit request',
            default => 'Update on your site visit request',
        };

        return new Envelope(
            subject: $subject.' — '.config('acremann.company_name', 'Acremann Properties'),
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.site-visit-booking-status');
    }
}
