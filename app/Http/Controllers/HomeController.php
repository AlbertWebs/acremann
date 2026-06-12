<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\Post;
use App\Models\Property;
use App\Models\TeamMember;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home-full-width', $this->homeData());
    }

    public function classic()
    {
        return view('pages.home', $this->homeData());
    }

    /**
     * @return array<string, mixed>
     */
    private function homeData(): array
    {
        return [
            'settings' => $this->settings(),
            'featuredProperties' => Property::published()->featured()->with('plots')->orderBy('sort_order')->take(6)->get(),
            'properties' => Property::published()->with('plots')->orderBy('sort_order')->take(3)->get(),
            'testimonials' => Testimonial::published()->where('is_featured', true)->orderBy('sort_order')->get(),
            'team' => TeamMember::published()->take(2)->get(),
            'certifications' => Certification::published()->take(8)->get(),
            'posts' => Post::published()->take(3)->get(),
        ];
    }
}
