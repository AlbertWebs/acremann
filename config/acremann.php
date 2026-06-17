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
    'brand_video_url' => env('ACREMANN_BRAND_VIDEO_URL')
        ?: env('ACREMANN_HOMEPAGE_HERO_VIDEO_URL')
        ?: 'https://vimeo.com/1197477405',
    'homepage_hero_video_url' => env('ACREMANN_HOMEPAGE_HERO_VIDEO_URL')
        ?: env('ACREMANN_BRAND_VIDEO_URL')
        ?: 'https://vimeo.com/1197477405',

    'local_business' => [
        'name' => env('ACREMANN_LOCAL_NAME', 'Acremann Properties Limited'),
        'legal_name' => 'Acremann Properties Limited',
        'latitude' => (float) env('ACREMANN_LATITUDE', -1.2710368),
        'longitude' => (float) env('ACREMANN_LONGITUDE', 36.8444699),
        'google_maps_url' => env(
            'ACREMANN_GOOGLE_MAPS_URL',
            'https://www.google.com/maps/place/Acremann+Properties+Limited/@-1.2710368,36.8444699,11z/data=!3m1!4b1!4m6!3m5!1s0x606c82403636367:0x10d784ccc3816137!8m2!3d-1.2710368!4d36.8444699!16s%2Fg%2F11y0rrhq4_'
        ),
        'street_address' => env('ACREMANN_STREET_ADDRESS'),
        'locality' => env('ACREMANN_LOCALITY', 'Nairobi'),
        'region' => env('ACREMANN_REGION', 'Nairobi County'),
        'postal_code' => env('ACREMANN_POSTAL_CODE'),
        'country' => env('ACREMANN_COUNTRY', 'KE'),
        'area_served' => ['Nairobi', 'Kiambu', 'Kikuyu', 'Nachu', 'Kenya'],
    ],
];
