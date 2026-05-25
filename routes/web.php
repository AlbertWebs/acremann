<?php

use App\Http\Controllers\AssistantController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SiteVisitBookingController;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/invest', [PageController::class, 'invest'])->name('invest');
Route::get('/sustainability', [PageController::class, 'sustainability'])->name('sustainability');
Route::get('/certifications', [PageController::class, 'certifications'])->name('certifications');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/book-visit', [PageController::class, 'bookVisit'])->name('book-visit');
Route::post('/book-visit', [SiteVisitBookingController::class, 'store'])
    ->name('book-visit.store')
    ->middleware('throttle:10,1');
Route::get('/referrals', [PageController::class, 'referrals'])->name('referrals');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');

Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{slug}', [PropertyController::class, 'show'])->name('properties.show');

Route::get('/insights', [PostController::class, 'index'])->name('posts.index');
Route::get('/insights/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/client-portal', [ClientPortalController::class, 'index'])->name('client-portal');
Route::get('/client-portal/statement/{lookup}', [ClientPortalController::class, 'downloadStatement'])
    ->name('client-portal.statement')
    ->middleware('signed');
Route::middleware(['throttle:client-portal', ProtectAgainstSpam::class])->group(function () {
    Route::post('/client-portal/title', [ClientPortalController::class, 'titleStatus'])->name('client-portal.title');
    Route::post('/client-portal/payment', [ClientPortalController::class, 'paymentStatus'])->name('client-portal.payment');
});

Route::post('/leads', [LeadController::class, 'store'])->name('leads.store')->middleware('throttle:10,1');
Route::post('/newsletter', [LeadController::class, 'newsletter'])->name('newsletter.subscribe')->middleware('throttle:10,1');
Route::post('/properties/{property}/brochure', [LeadController::class, 'brochure'])->name('properties.brochure')->middleware('throttle:10,1');
Route::post('/assistant/track', [AssistantController::class, 'track'])->name('assistant.track')->middleware('throttle:60,1');
Route::post('/chatbot', [LeadController::class, 'chatbot'])->name('chatbot.store')->middleware('throttle:20,1');
