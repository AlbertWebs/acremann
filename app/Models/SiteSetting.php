<?php

namespace App\Models;

use App\Support\PublicStorage;
use App\Support\VideoEmbed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SiteSetting extends Model
{
    public const HOMEPAGE_HERO_GRID_LIMIT = 3;

    protected $fillable = [
        'company_name', 'tagline', 'logo_path', 'logo_white_path', 'logo_footer_path', 'favicon_path',
        'hero_eyebrow', 'hero_headline', 'hero_description',
        'hero_cta_primary_label', 'hero_cta_primary_url',
        'hero_cta_secondary_label', 'hero_cta_secondary_url',
        'hero_show_whatsapp_cta', 'hero_whatsapp_label',
        'hero_media_mode', 'hero_image_path', 'hero_images',
        'hero_video_enabled', 'hero_video_provider', 'hero_video_url', 'hero_video_path',
        'assistant_heading', 'assistant_subheading', 'assistant_title_body',
        'assistant_title_link_label', 'assistant_title_link_url', 'assistant_whatsapp_label',
        'assistant_consent_text', 'assistant_success_message',
        'assistant_buyer_types', 'assistant_budget_ranges',
        'mission', 'vision', 'about_summary',
        'whatsapp', 'phone', 'email', 'address', 'youtube_url', 'podcast_url',
        'facebook_url', 'instagram_url', 'linkedin_url', 'csr_statement',
        'referral_program', 'sustainability_intro', 'investment_intro',
        'services_page_eyebrow', 'services_page_headline', 'services_page_lead',
        'services_page_section_title', 'services_page_section_lead',
        'ga_measurement_id', 'gtm_container_id', 'meta_pixel_id',
    ];

    protected function casts(): array
    {
        return [
            'hero_show_whatsapp_cta' => 'boolean',
            'hero_video_enabled' => 'boolean',
            'hero_images' => 'array',
            'assistant_buyer_types' => 'array',
            'assistant_budget_ranges' => 'array',
        ];
    }

    public static function current(): self
    {
        $settings = static::query()->orderBy('id')->first();

        if ($settings === null) {
            return static::create([
                'company_name' => 'Acremann Properties',
                'tagline' => 'Trusted guidance. Transparent process. Sustainable value.',
                'whatsapp' => config('acremann.whatsapp'),
                'phone' => config('acremann.phone'),
                'phone' => config('acremann.phone'),
                'email' => config('acremann.email'),
            ]);
        }

        static::query()->whereKeyNot($settings->id)->delete();

        return $settings;
    }

    public function whatsappNumber(): string
    {
        return preg_replace('/\D/', '', $this->whatsapp ?? config('acremann.whatsapp'));
    }

    public function whatsappUrl(?string $message = null): string
    {
        $url = 'https://wa.me/'.$this->whatsappNumber();
        if ($message) {
            $url .= '?text='.urlencode($message);
        }

        return $url;
    }

    public function themeLogoUrl(): ?string
    {
        return $this->assetUrl($this->logo_path);
    }

    public function whiteLogoUrl(): ?string
    {
        return $this->assetUrl($this->logo_white_path);
    }

    public function footerLogoUrl(): ?string
    {
        return $this->assetUrl($this->logo_footer_path) ?? $this->themeLogoUrl();
    }

    public function logoUrl(): ?string
    {
        return $this->themeLogoUrl();
    }

    public function faviconUrl(): ?string
    {
        return $this->assetUrl($this->favicon_path);
    }

    public function heroImageUrl(): ?string
    {
        return $this->heroImageUrls()[0] ?? null;
    }

    /**
     * @return list<string>
     */
    public function heroImagePaths(): array
    {
        $images = $this->hero_images;

        if (is_array($images) && $images !== []) {
            return array_values(array_filter($images, fn (mixed $path): bool => is_string($path) && $path !== ''));
        }

        if (filled($this->hero_image_path)) {
            return [$this->hero_image_path];
        }

        return [];
    }

    /**
     * @return list<string>
     */
    public function heroImageUrls(): array
    {
        return array_values(array_filter(array_map(
            fn (string $path): ?string => $this->assetUrl($path),
            $this->heroImagePaths(),
        )));
    }

    /**
     * Images shown in the homepage hero grid (1 large + 2 small).
     *
     * @return list<string>
     */
    public function homepageHeroImageUrls(): array
    {
        return array_slice($this->heroImageUrls(), 0, self::HOMEPAGE_HERO_GRID_LIMIT);
    }

    /**
     * Images for the two smaller hero grid cells when the large slot uses video.
     *
     * @return list<string>
     */
    public function homepageHeroSecondaryImageUrls(): array
    {
        return array_slice($this->heroImageUrls(), 0, 2);
    }

    public function heroVideoEnabled(): bool
    {
        return (bool) $this->hero_video_enabled && $this->heroVideoPayload() !== null;
    }

    /**
     * @return array{type: 'iframe', provider: string, embed_url: string}|array{type: 'file', src: string}|null
     */
    public function heroVideoPayload(): ?array
    {
        if (! $this->hero_video_enabled) {
            return null;
        }

        if ($this->hero_video_provider === 'upload') {
            $src = $this->assetUrl($this->hero_video_path);

            return $src ? ['type' => 'file', 'src' => $src] : null;
        }

        if (in_array($this->hero_video_provider, ['youtube', 'vimeo'], true)) {
            return VideoEmbed::fromUrl($this->hero_video_url);
        }

        return null;
    }

    public function heroShowsPrimaryVideo(): bool
    {
        return $this->heroShowsGallery() && $this->heroVideoEnabled();
    }

    public function heroEyebrow(): string
    {
        return $this->hero_eyebrow ?: 'Trusted real estate company Kenya';
    }

    public function heroHeadline(): string
    {
        return $this->hero_headline ?: $this->tagline ?: 'Trusted guidance. Transparent process. Sustainable value.';
    }

    public function heroDescription(): string
    {
        return $this->hero_description ?: 'Clean title deeds, verified plots, and professional property advisory across Nairobi, Kiambu, Kikuyu and Nachu. Buy land in Kenya with confidence — including diaspora-friendly remote purchase support.';
    }

    public function servicesPageEyebrow(): string
    {
        return $this->services_page_eyebrow ?: 'What we offer';
    }

    public function servicesPageHeadline(): string
    {
        return $this->services_page_headline ?: 'Professional property services';
    }

    public function servicesPageLead(): string
    {
        return $this->services_page_lead ?: 'From verified land sales and investment advisory to conveyancing and diaspora support — transparent, legally-grounded solutions for buyers in Kenya and abroad.';
    }

    public function servicesPageSectionTitle(): string
    {
        return $this->services_page_section_title ?: 'Explore our services';
    }

    public function servicesPageSectionLead(): string
    {
        return $this->services_page_section_lead ?: 'Each service has a dedicated page with guidance for local buyers and diaspora investors.';
    }

    /**
     * Plain-text version of a rich-editor field (no visible HTML tags on the public site).
     */
    public function plainTextFromRich(?string $html, string $default = ''): string
    {
        if (blank($html)) {
            return $default;
        }

        $text = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return Str::squish(strip_tags($text));
    }

    public function aboutSummary(): string
    {
        return $this->plainTextFromRich(
            $this->about_summary,
            'Acremann Properties is a professional real estate firm specialising in verified residential and commercial plots across Nairobi, Kiambu, Kikuyu and Nachu.',
        );
    }

    public function missionStatement(): string
    {
        return $this->plainTextFromRich(
            $this->mission,
            'To deliver legally-grounded, financially-disciplined land and property solutions that build lasting legacy for our clients.',
        );
    }

    public function visionStatement(): string
    {
        return $this->plainTextFromRich(
            $this->vision,
            'To be Kenya\'s most trusted advisory-led real estate firm for clean-title land investment.',
        );
    }

    public function investmentIntro(): string
    {
        return $this->plainTextFromRich(
            $this->investment_intro,
            'Whether you are building, investing, or buying from abroad, Acremann provides transparent advisory from first conversation to title handover.',
        );
    }

    public function sustainabilityIntro(): string
    {
        return $this->plainTextFromRich(
            $this->sustainability_intro,
            'Responsible land use, green open spaces, and solar-ready planning guide every Acremann development. We plan tree planting, drainage, and protected open space from the start, with clear sustainability markers on every project across Nairobi, Kiambu, Kikuyu and Nachu.',
        );
    }

    public function csrStatement(): string
    {
        return $this->plainTextFromRich(
            $this->csr_statement,
            'We invest in community tree planting, drainage improvements, and ethical land stewardship across every project.',
        );
    }

    public function heroPrimaryCta(): array
    {
        return [
            'label' => $this->hero_cta_primary_label ?: 'View properties',
            'url' => $this->resolveUrl($this->hero_cta_primary_url, route('properties.index')),
        ];
    }

    public function heroSecondaryCta(): array
    {
        return [
            'label' => $this->hero_cta_secondary_label ?: 'Book a site visit',
            'url' => $this->resolveUrl($this->hero_cta_secondary_url, route('contact')),
        ];
    }

    public function heroWhatsappLabel(): string
    {
        return $this->hero_whatsapp_label ?: 'WhatsApp us';
    }

    public function heroShowsWhatsappCta(): bool
    {
        return $this->hero_show_whatsapp_cta ?? true;
    }

    public function heroShowsFeaturedProperties(): bool
    {
        return ($this->hero_media_mode ?: 'featured_properties') === 'featured_properties';
    }

    public function heroShowsImage(): bool
    {
        return $this->heroShowsGallery();
    }

    public function heroShowsGallery(): bool
    {
        return in_array($this->hero_media_mode, ['gallery', 'image'], true)
            && $this->heroImagePaths() !== [];
    }

    public function heroIsTextOnly(): bool
    {
        return $this->hero_media_mode === 'none';
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    public function assistantBuyerTypes(): array
    {
        return $this->assistant_buyer_types ?: [
            ['value' => 'individual', 'label' => 'Individual buyer'],
            ['value' => 'diaspora', 'label' => 'Diaspora investor'],
            ['value' => 'investor', 'label' => 'Institutional investor'],
            ['value' => 'developer', 'label' => 'Developer / partner'],
        ];
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    public function assistantBudgetRanges(): array
    {
        return $this->assistant_budget_ranges ?: [
            ['value' => 'under_1m', 'label' => 'Under KES 1M'],
            ['value' => '1m_3m', 'label' => 'KES 1M – 3M'],
            ['value' => '3m_10m', 'label' => 'KES 3M – 10M'],
            ['value' => 'over_10m', 'label' => 'Over KES 10M'],
        ];
    }

    protected function resolveUrl(?string $url, string $default): string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return $default;
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, '//')) {
            return $url;
        }

        return '/'.ltrim($url, '/');
    }

    protected function assetUrl(?string $path): ?string
    {
        return PublicStorage::url($path);
    }
}
