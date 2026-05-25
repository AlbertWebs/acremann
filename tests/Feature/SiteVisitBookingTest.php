<?php

namespace Tests\Feature;

use App\Enums\SiteVisitBookingStatus;
use App\Http\Controllers\SiteVisitBookingController;
use App\Mail\SiteVisitBookingAdminNotification;
use App\Mail\SiteVisitBookingConfirmation;
use App\Mail\SiteVisitBookingStatusUpdated;
use App\Models\SiteVisitBooking;
use App\Services\SiteVisitBookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SiteVisitBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_visit_form_creates_booking_and_sends_emails(): void
    {
        Mail::fake();

        $this->postJson('/book-visit', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '0712345678',
            'message' => 'Saturday morning preferred',
            'visit_format' => 'virtual',
            'consent_callback' => '1',
            'consent_email' => '1',
        ])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => SiteVisitBookingController::SUCCESS_MESSAGE,
            ]);

        $booking = SiteVisitBooking::query()->where('email', 'jane@example.com')->first();
        $this->assertNotNull($booking);
        $this->assertStringContainsString('Virtual visit', $booking->message);
        $this->assertStringContainsString('Saturday morning preferred', $booking->message);

        Mail::assertQueued(SiteVisitBookingAdminNotification::class);
        Mail::assertQueued(SiteVisitBookingConfirmation::class);
    }

    public function test_booking_without_email_only_notifies_admin(): void
    {
        Mail::fake();

        $this->postJson('/book-visit', [
            'name' => 'John Doe',
            'phone' => '0798765432',
            'consent_callback' => '1',
        ])->assertOk();

        Mail::assertQueued(SiteVisitBookingAdminNotification::class);
        Mail::assertNotQueued(SiteVisitBookingConfirmation::class);
    }

    public function test_confirming_booking_emails_client(): void
    {
        Mail::fake();

        $booking = SiteVisitBooking::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '0712345678',
            'consent_callback' => true,
            'status' => SiteVisitBookingStatus::Pending,
        ]);

        app(SiteVisitBookingService::class)->updateStatus($booking, SiteVisitBookingStatus::Confirmed);

        Mail::assertQueued(SiteVisitBookingStatusUpdated::class);
    }
}
