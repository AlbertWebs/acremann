<?php

namespace App\Mail;

use App\Models\SiteVisitBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SiteVisitBookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public SiteVisitBooking $booking) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We received your site visit request — '.config('acremann.company_name', 'Acremann Properties'),
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.site-visit-booking-confirmation');
    }
}
