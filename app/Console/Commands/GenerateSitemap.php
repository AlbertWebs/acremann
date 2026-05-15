<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Property;
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

        foreach (['/', '/about', '/services', '/properties', '/invest', '/sustainability', '/certifications', '/insights', '/faqs', '/contact', '/referrals', '/privacy', '/client-portal'] as $path) {
            $sitemap->add(Url::create(url($path))->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        }

        Property::published()->each(fn ($p) => $sitemap->add(
            Url::create(route('properties.show', $p->slug))->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ));

        Post::published()->each(fn ($p) => $sitemap->add(
            Url::create(route('posts.show', $p->slug))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        ));

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated at public/sitemap.xml');

        return self::SUCCESS;
    }
}
