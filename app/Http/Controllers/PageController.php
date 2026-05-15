<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about', [
            'settings' => $this->settings(),
            'team' => TeamMember::published()->get(),
            'leadership' => TeamMember::published()->where('is_leadership', true)->get(),
        ]);
    }

    public function services()
    {
        return view('pages.services', [
            'settings' => $this->settings(),
            'services' => Service::published()->get(),
        ]);
    }

    public function invest()
    {
        $page = Page::findBySlug('invest');

        return view('pages.invest', [
            'settings' => $this->settings(),
            'page' => $page,
        ]);
    }

    public function sustainability()
    {
        return view('pages.sustainability', [
            'settings' => $this->settings(),
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

    public function referrals()
    {
        return view('pages.referrals', [
            'settings' => $this->settings(),
        ]);
    }

    public function privacy()
    {
        $page = Page::findBySlug('privacy');

        return view('pages.privacy', [
            'settings' => $this->settings(),
            'page' => $page,
        ]);
    }
}
