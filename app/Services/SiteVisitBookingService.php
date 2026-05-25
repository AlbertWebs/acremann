<?php

namespace App\Services;

use App\Enums\SiteVisitBookingStatus;
use App\Mail\SiteVisitBookingAdminNotification;
use App\Mail\SiteVisitBookingConfirmation;
use App\Mail\SiteVisitBookingStatusUpdated;
use App\Models\SiteVisitBooking;
use Illuminate\Support\Facades\Mail;

class SiteVisitBookingService
{
    public function store(array $data): SiteVisitBooking
    {
        foreach (['consent_callback', 'consent_whatsapp', 'consent_email', 'consent_marketing'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = (bool) $data[$field];
            }
        }

        $data['status'] = SiteVisitBookingStatus::Pending;

        $booking = SiteVisitBooking::create($data);

        $this->sendSubmissionEmails($booking);

        return $booking;
    }

    public function updateStatus(SiteVisitBooking $booking, SiteVisitBookingStatus $status): SiteVisitBooking
    {
        $booking->update([
            'status' => $status,
            'processed_at' => $status === SiteVisitBookingStatus::Pending ? null : now(),
        ]);

        $this->notifyStatusChange($booking->refresh());

        return $booking;
    }

    public function notifyStatusChange(SiteVisitBooking $booking): void
    {
        if (filled($booking->email)) {
            $this->sendStatusEmail($booking, $booking->status);
        }
    }

    protected function sendSubmissionEmails(SiteVisitBooking $booking): void
    {
        Mail::to(config('acremann.lead_notification_email'))
            ->queue(new SiteVisitBookingAdminNotification($booking));

        if (filled($booking->email)) {
            Mail::to($booking->email)
                ->queue(new SiteVisitBookingConfirmation($booking));
        }
    }

    protected function sendStatusEmail(SiteVisitBooking $booking, SiteVisitBookingStatus $status): void
    {
        if (in_array($status, [SiteVisitBookingStatus::Confirmed, SiteVisitBookingStatus::Cancelled], true)) {
            Mail::to($booking->email)
                ->queue(new SiteVisitBookingStatusUpdated($booking));
        }
    }
}
