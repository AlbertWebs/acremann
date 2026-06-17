@props([
    'pageTitle' => null,
    'pageDescription' => null,
    'pageUrl' => null,
])
@php
    use App\Support\Seo;

    $title = $pageTitle ?: Seo::pageTitle(null);
    $description = Seo::description($pageDescription);
    $url = $pageUrl ?: url()->current();

    $graph = Seo::graph([
        Seo::organizationSchema(),
        Seo::websiteSchema(),
        Seo::webPageSchema($title, $description, $url),
    ]);
@endphp
<script type="application/ld+json">{!! Seo::jsonLd($graph) !!}</script>
