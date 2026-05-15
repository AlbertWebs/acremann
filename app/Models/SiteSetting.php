<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'company_name', 'tagline', 'mission', 'vision', 'about_summary',
        'whatsapp', 'phone', 'email', 'address', 'youtube_url', 'podcast_url',
        'facebook_url', 'instagram_url', 'linkedin_url', 'csr_statement',
        'referral_program', 'sustainability_intro', 'investment_intro',
        'ga_measurement_id', 'gtm_container_id', 'meta_pixel_id',
    ];

    public static function current(): self
    {
        $settings = static::query()->orderBy('id')->first();

        if ($settings === null) {
            return static::create([
                'company_name' => 'Acremann Properties',
                'tagline' => 'Trusted guidance. Transparent process. Sustainable value.',
                'whatsapp' => config('acremann.whatsapp'),
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
}
