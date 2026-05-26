<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Post;
use App\Models\TeamMember;
use App\Models\Property;
use App\Models\Service;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the XML sitemap';

    public function handle(): int
    {
        $sitemap = Sitemap::create();

        foreach (['/', '/about', '/leadership', '/services', '/properties', '/invest', '/sustainability', '/certifications', '/insights', '/events', '/faqs', '/contact', '/book-visit', '/referrals', '/privacy', '/terms', '/client-portal'] as $path) {
            $sitemap->add(Url::create(url($path))->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        }

        Property::published()->each(fn ($p) => $sitemap->add(
            Url::create(route('properties.show', $p->slug))->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ));

        Post::published()->each(fn ($p) => $sitemap->add(
            Url::create(route('posts.show', $p->slug))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        ));

        Event::published()->each(fn ($e) => $sitemap->add(
            Url::create(route('events.show', $e->slug))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        ));

        TeamMember::published()->leadership()->each(fn ($m) => $sitemap->add(
            Url::create(route('leadership.show', $m))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        ));

        Service::published()->each(fn ($s) => $sitemap->add(
            Url::create(route('services.show', $s->slug))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        ));

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated at public/sitemap.xml');

        return self::SUCCESS;
    }
}
