<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::published()->orderBy('sort_order');

        if ($request->filled('county')) {
            $query->where('county', $request->county);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('title_type')) {
            $query->where('title_type', $request->title_type);
        }
        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%")
                    ->orWhere('county', 'like', "%{$q}%");
            });
        }

        $properties = $query->paginate(12)->withQueryString();

        return view('properties.index', [
            'settings' => $this->settings(),
            'properties' => $properties,
            'counties' => Property::published()->whereNotNull('county')->distinct()->pluck('county'),
            'filters' => $request->only(['county', 'category', 'title_type', 'listing_type', 'status', 'q']),
        ]);
    }

    public function show(string $slug)
    {
        $property = Property::where('slug', $slug)->published()->firstOrFail();

        return view('properties.show', [
            'settings' => $this->settings(),
            'property' => $property->load(['plots', 'faqs']),
            'related' => Property::published()
                ->where('id', '!=', $property->id)
                ->where(function ($q) use ($property) {
                    $q->where('county', $property->county)
                        ->orWhere('category', $property->category);
                })
                ->take(3)
                ->get(),
        ]);
    }
}
