<?php

namespace App\Support;

class VideoEmbed
{
    /**
     * @return array{type: 'iframe', provider: string, embed_url: string}|null
     */
    public static function fromUrl(?string $url): ?array
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        $youtubeId = self::youtubeId($url);

        if ($youtubeId !== null) {
            return [
                'type' => 'iframe',
                'provider' => 'youtube',
                'embed_url' => 'https://www.youtube-nocookie.com/embed/'.$youtubeId.'?autoplay=1&mute=1&loop=1&playlist='.$youtubeId.'&controls=0&rel=0&modestbranding=1&playsinline=1',
            ];
        }

        $vimeoId = self::vimeoId($url);

        if ($vimeoId !== null) {
            return [
                'type' => 'iframe',
                'provider' => 'vimeo',
                'embed_url' => 'https://player.vimeo.com/video/'.$vimeoId.'?background=1&autoplay=1&muted=1&loop=1',
            ];
        }

        return null;
    }

    public static function youtubeId(string $url): ?string
    {
        if (preg_match('~(?:youtube\.com/watch\?v=|youtube\.com/embed/|youtu\.be/)([a-zA-Z0-9_-]{11})~', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public static function vimeoId(string $url): ?string
    {
        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
