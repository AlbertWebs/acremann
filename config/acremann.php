<?php

return [
    'company_name' => env('ACREMANN_COMPANY_NAME', 'Acremann Properties'),
    'domain' => env('ACREMANN_DOMAIN', 'acremannproperties.com'),
    'url' => rtrim(env('APP_URL', 'https://acremannproperties.com'), '/'),
    'whatsapp' => env('ACREMANN_WHATSAPP', '254115874901'),
    'phone' => env('ACREMANN_PHONE', '0115 874 901'),
    'email' => env('ACREMANN_EMAIL', 'info@acremannproperties.com'),
    'crm_webhook_url' => env('CRM_WEBHOOK_URL'),
    'google_maps_key' => env('GOOGLE_MAPS_KEY'),
    'ga_measurement_id' => env('GA_MEASUREMENT_ID'),
    'gtm_container_id' => env('GTM_CONTAINER_ID'),
    'meta_pixel_id' => env('META_PIXEL_ID'),
    'lead_notification_email' => env('LEAD_NOTIFICATION_EMAIL', env('ACREMANN_EMAIL', 'info@acremannproperties.com')),
    'brand_video_url' => env('ACREMANN_BRAND_VIDEO_URL', env('ACREMANN_HOMEPAGE_HERO_VIDEO_URL', 'https://vimeo.com/1197477405')),
    'homepage_hero_video_url' => env('ACREMANN_HOMEPAGE_HERO_VIDEO_URL', env('ACREMANN_BRAND_VIDEO_URL', 'https://vimeo.com/1197477405')),
];
