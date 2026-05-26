<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use App\Models\Property;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index', [
            'settings' => $this->settings(),
            'events' => Event::published()->paginate(12),
        ]);
    }

    public function show(string $slug)
    {
        $event = Event::where('slug', $slug)->published()->firstOrFail();

        return view('events.show', [
            'settings' => $this->settings(),
            'event' => $event,
            'gallery' => $event->getMedia('gallery'),
            'otherEvents' => Event::published()
                ->whereKeyNot($event->id)
                ->take(3)
                ->get(),
            'sidebarProperties' => $this->sidebarProperties($event),
            'recentPosts' => Post::published()->take(3)->get(),
        ]);
    }

    /**
     * @return Collection<int, Property>
     */
    private function sidebarProperties(Event $event): Collection
    {
        if (filled($event->location)) {
            $countyHint = str_contains($event->location, ',')
                ? trim(Str::afterLast($event->location, ','))
                : null;
            $placeHint = str_contains($event->location, ',')
                ? trim(Str::beforeLast($event->location, ','))
                : $event->location;

            $matched = Property::query()
                ->published()
                ->where(function ($query) use ($countyHint, $placeHint) {
                    if ($countyHint && $placeHint) {
                        $query->where('county', 'like', '%'.$countyHint.'%')
                            ->orWhere(function ($query) use ($placeHint) {
                                $query->where('location', 'like', '%'.$placeHint.'%')
                                    ->orWhere('title', 'like', '%'.$placeHint.'%');
                            });
                    } elseif ($countyHint) {
                        $query->where('county', 'like', '%'.$countyHint.'%');
                    } elseif ($placeHint) {
                        $query->where('location', 'like', '%'.$placeHint.'%')
                            ->orWhere('title', 'like', '%'.$placeHint.'%');
                    }
                })
                ->orderByDesc('is_featured')
                ->orderByDesc('sort_order')
                ->take(3)
                ->get();

            if ($matched->isNotEmpty()) {
                return $matched;
            }
        }

        return Property::query()
            ->published()
            ->featured()
            ->orderByDesc('sort_order')
            ->take(3)
            ->get();
    }
}
