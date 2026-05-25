<?php

namespace App\Mail;

use App\Models\SiteVisitBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SiteVisitBookingAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public SiteVisitBooking $booking) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New site visit booking — '.$this->booking->name,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.site-visit-booking-admin');
    }
}
