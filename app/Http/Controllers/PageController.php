<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Property;
use App\Models\TeamMember;
use App\Models\Testimonial;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about', [
            'settings' => $this->settings(),
            'leadership' => TeamMember::published()->leadership()->get(),
            'team' => TeamMember::published()->where('is_leadership', false)->get(),
        ]);
    }

    public function invest()
    {
        $page = Page::findBySlug('invest');

        return view('pages.invest', [
            'settings' => $this->settings(),
            'page' => $page,
            'featuredProperties' => Property::published()->featured()->with('plots')->orderBy('sort_order')->take(3)->get(),
            'testimonials' => Testimonial::published()->where('is_featured', true)->orderBy('sort_order')->take(3)->get(),
        ]);
    }

    public function sustainability()
    {
        $impactProperties = Property::published()
            ->whereNotNull('sustainability_markers')
            ->orderBy('sort_order')
            ->get();

        $impactMarkers = $impactProperties
            ->pluck('sustainability_markers')
            ->flatten()
            ->filter()
            ->unique()
            ->values();

        return view('pages.sustainability', [
            'settings' => $this->settings(),
            'impactMarkers' => $impactMarkers,
            'impactPropertyCount' => $impactProperties->count(),
        ]);
    }

    public function certifications()
    {
        return view('pages.certifications', [
            'settings' => $this->settings(),
            'certifications' => Certification::published()->get(),
        ]);
    }

    public function faqs()
    {
        return view('pages.faqs', [
            'settings' => $this->settings(),
            'faqs' => Faq::published()->get()->groupBy('category'),
        ]);
    }

    public function contact()
    {
        return view('pages.contact', [
            'settings' => $this->settings(),
        ]);
    }

    public function bookVisit()
    {
        return view('pages.book-visit', [
            'settings' => $this->settings(),
            'properties' => Property::published()->orderBy('title')->get(['id', 'title', 'location', 'county']),
        ]);
    }

    public function referrals()
    {
        return view('pages.referrals', [
            'settings' => $this->settings(),
        ]);
    }

    public function privacy()
    {
        return view('pages.privacy', [
            'settings' => $this->settings(),
            'page' => Page::findBySlug('privacy'),
        ]);
    }

    public function terms()
    {
        return view('pages.terms', [
            'settings' => $this->settings(),
            'page' => Page::findBySlug('terms'),
        ]);
    }
}
