<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('pages.services', [
            'settings' => $this->settings(),
            'services' => Service::published()->get(),
        ]);
    }

    public function show(string $slug)
    {
        $service = Service::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('services.show', [
            'settings' => $this->settings(),
            'service' => $service,
            'otherServices' => Service::published()
                ->where('id', '!=', $service->id)
                ->get(),
        ]);
    }
}
