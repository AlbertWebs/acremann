<?php

namespace App\Support;

use App\Models\Faq;
use App\Models\Post;
use App\Models\Property;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Seo
{
    public static function pageTitle(?string $title, ?string $siteName = null): string
    {
        $siteName = $siteName ?: static::siteName();

        if (! filled($title)) {
            return "{$siteName} | Verified Plots & Land for Sale in Kenya";
        }

        if (Str::contains($title, $siteName)) {
            return $title;
        }

        return "{$title} | {$siteName}";
    }

    public static function description(?string $description = null): string
    {
        $text = filled($description)
            ? strip_tags((string) $description)
            : static::defaultDescription();

        return static::truncate($text, 160);
    }

    public static function defaultDescription(): string
    {
        return 'Acremann Properties — verified plots and land for sale in Nairobi, Kiambu, Kikuyu & Nachu. Clean freehold title deeds, diaspora-friendly purchase support, and transparent conveyancing across Kenya.';
    }

    public static function defaultKeywords(): string
    {
        return 'Acremann Properties, land for sale Kenya, plots Nairobi, plots Kiambu, plots Kikuyu, Nachu plots, clean title deeds, diaspora land purchase Kenya, verified plots, real estate Kenya';
    }

    public static function siteName(): string
    {
        return SiteSetting::current()->company_name ?: config('acremann.company_name', 'Acremann Properties');
    }

    public static function siteUrl(): string
    {
        return config('acremann.url');
    }

    public static function defaultImageUrl(): ?string
    {
        $settings = SiteSetting::current();
        $logo = $settings->logoUrl() ?? $settings->footerLogoUrl();

        return filled($logo) ? url($logo) : null;
    }

    public static function imageUrl(?string $image): ?string
    {
        if (! filled($image)) {
            return static::defaultImageUrl();
        }

        return str_starts_with($image, 'http') ? $image : url($image);
    }

    public static function truncate(string $text, int $limit = 160): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', $text) ?? '');

        if (mb_strlen($text) <= $limit) {
            return $text;
        }

        return rtrim(mb_substr($text, 0, $limit - 1)).'…';
    }

    /**
     * @return array<string, mixed>
     */
    public static function organizationSchema(): array
    {
        $settings = SiteSetting::current();
        $local = config('acremann.local_business');
        $siteUrl = static::siteUrl();

        return array_filter([
            '@type' => ['RealEstateAgent', 'LocalBusiness'],
            '@id' => "{$siteUrl}/#organization",
            'name' => $local['name'] ?? static::siteName(),
            'legalName' => $local['legal_name'] ?? 'Acremann Properties Limited',
            'url' => $siteUrl,
            'logo' => static::defaultImageUrl(),
            'image' => static::defaultImageUrl(),
            'description' => static::defaultDescription(),
            'email' => $settings->email ?: config('acremann.email'),
            'telephone' => $settings->phone ?: config('acremann.phone'),
            'priceRange' => 'KES',
            'currenciesAccepted' => 'KES',
            'paymentAccepted' => 'Cash, Bank Transfer, Installments',
            'areaServed' => $local['area_served'] ?? ['Nairobi', 'Kiambu', 'Kikuyu', 'Nachu', 'Kenya'],
            'knowsAbout' => [
                'Residential land for sale',
                'Clean title deeds Kenya',
                'Diaspora property purchase',
                'Land investment advisory',
                'Conveyancing',
            ],
            'sameAs' => array_values(array_filter([
                $local['google_maps_url'] ?? null,
                $settings->youtube_url ?? null,
            ])),
            'hasMap' => $local['google_maps_url'] ?? null,
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $local['latitude'] ?? null,
                'longitude' => $local['longitude'] ?? null,
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $local['street_address'] ?? ($settings->address ?: null),
                'addressLocality' => $local['locality'] ?? 'Nairobi',
                'addressRegion' => $local['region'] ?? 'Nairobi County',
                'postalCode' => $local['postal_code'] ?? null,
                'addressCountry' => $local['country'] ?? 'KE',
            ],
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '08:00',
                'closes' => '17:00',
            ],
        ], fn (mixed $value): bool => $value !== null && $value !== []);
    }

    /**
     * @return array<string, mixed>
     */
    public static function websiteSchema(): array
    {
        $siteUrl = static::siteUrl();

        return [
            '@type' => 'WebSite',
            '@id' => "{$siteUrl}/#website",
            'url' => $siteUrl,
            'name' => static::siteName(),
            'description' => static::defaultDescription(),
            'publisher' => ['@id' => "{$siteUrl}/#organization"],
            'inLanguage' => 'en-KE',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => "{$siteUrl}/properties?q={search_term_string}",
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function webPageSchema(string $name, string $description, string $url): array
    {
        $siteUrl = static::siteUrl();

        return [
            '@type' => 'WebPage',
            '@id' => "{$url}#webpage",
            'url' => $url,
            'name' => $name,
            'description' => static::truncate($description, 320),
            'isPartOf' => ['@id' => "{$siteUrl}/#website"],
            'about' => ['@id' => "{$siteUrl}/#organization"],
            'inLanguage' => 'en-KE',
        ];
    }

    /**
     * @param  array<int, array{name: string, url: string}>  $items
     * @return array<string, mixed>
     */
    public static function breadcrumbSchema(array $items): array
    {
        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(
                fn (array $item, int $index): array => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['name'],
                    'item' => $item['url'],
                ]
            )->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function propertyListingSchema(Property $property, string $url): array
    {
        $hero = $property->getFirstMedia('hero') ?? $property->getFirstMedia('gallery');
        $image = $hero ? $property->mediaUrl($hero, null) : null;

        return array_filter([
            '@type' => 'RealEstateListing',
            'name' => $property->title,
            'description' => static::truncate(strip_tags((string) ($property->meta_description ?: $property->summary ?: $property->description)), 320),
            'url' => $url,
            'image' => $image ? url($image) : null,
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $property->location,
                'addressRegion' => $property->county,
                'addressCountry' => 'KE',
            ],
            'offers' => filled($property->price_from) ? [
                '@type' => 'Offer',
                'price' => (float) $property->price_from,
                'priceCurrency' => 'KES',
                'availability' => $property->isSoldOut()
                    ? 'https://schema.org/SoldOut'
                    : 'https://schema.org/InStock',
            ] : null,
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return array<string, mixed>
     */
    public static function articleSchema(Post $post, string $url): array
    {
        return array_filter([
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => static::truncate((string) $post->seoDescription(), 320),
            'url' => $url,
            'image' => $post->featuredImageUrl() ? url($post->featuredImageUrl()) : null,
            'datePublished' => $post->published_at?->toAtomString(),
            'dateModified' => $post->updated_at?->toAtomString(),
            'author' => filled($post->author) ? [
                '@type' => 'Person',
                'name' => $post->author,
            ] : ['@type' => 'Organization', 'name' => static::siteName()],
            'publisher' => [
                '@type' => 'Organization',
                'name' => static::siteName(),
                'logo' => static::defaultImageUrl() ? [
                    '@type' => 'ImageObject',
                    'url' => static::defaultImageUrl(),
                ] : null,
            ],
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return array<string, mixed>
     */
    public static function serviceSchema(Service $service, string $url): array
    {
        return array_filter([
            '@type' => 'Service',
            'name' => $service->title,
            'description' => static::truncate($service->seoDescription(), 320),
            'url' => $url,
            'image' => $service->featuredImageUrl() ? url($service->featuredImageUrl()) : null,
            'provider' => ['@id' => static::siteUrl().'/#organization'],
            'areaServed' => config('acremann.local_business.area_served', ['Kenya']),
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * @param  Collection<int, Faq>|iterable<int, Faq>  $faqs
     * @return array<string, mixed>|null
     */
    public static function faqPageSchema(iterable $faqs): ?array
    {
        $items = collect($faqs)->flatten();

        if ($items->isEmpty()) {
            return null;
        }

        return [
            '@type' => 'FAQPage',
            'mainEntity' => $items->map(fn (Faq $faq): array => [
                '@type' => 'Question',
                'name' => $faq->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags((string) $faq->answer),
                ],
            ])->values()->all(),
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $nodes
     * @return array<string, mixed>
     */
    public static function graph(array $nodes): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => array_values(array_filter($nodes)),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function jsonLd(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }
}
