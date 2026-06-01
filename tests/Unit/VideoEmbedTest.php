<?php

namespace Tests\Unit;

use App\Support\VideoEmbed;
use PHPUnit\Framework\TestCase;

class VideoEmbedTest extends TestCase
{
    public function test_parses_youtube_watch_url(): void
    {
        $embed = VideoEmbed::fromUrl('https://www.youtube.com/watch?v=dQw4w9WgXcQ');

        $this->assertNotNull($embed);
        $this->assertSame('youtube', $embed['provider']);
        $this->assertStringContainsString('youtube-nocookie.com/embed/dQw4w9WgXcQ', $embed['embed_url']);
    }

    public function test_parses_youtube_short_url(): void
    {
        $embed = VideoEmbed::fromUrl('https://youtu.be/dQw4w9WgXcQ');

        $this->assertNotNull($embed);
        $this->assertSame('youtube', $embed['provider']);
    }

    public function test_parses_vimeo_url(): void
    {
        $embed = VideoEmbed::fromUrl('https://vimeo.com/123456789');

        $this->assertNotNull($embed);
        $this->assertSame('vimeo', $embed['provider']);
        $this->assertStringContainsString('player.vimeo.com/video/123456789', $embed['embed_url']);
    }

    public function test_returns_null_for_invalid_url(): void
    {
        $this->assertNull(VideoEmbed::fromUrl('https://example.com/not-a-video'));
    }

    public function test_vimeo_thumbnail_url(): void
    {
        $url = VideoEmbed::vimeoThumbnailUrl('https://vimeo.com/1197477405');

        $this->assertSame('https://vumbnail.com/1197477405.jpg', $url);
    }

    public function test_modal_embed_for_vimeo_includes_autoplay_and_privacy_params(): void
    {
        $embed = VideoEmbed::modalFromUrl('https://vimeo.com/1197477405?share=copy');

        $this->assertNotNull($embed);
        $this->assertSame('vimeo', $embed['provider']);
        $this->assertStringContainsString('player.vimeo.com/video/1197477405', $embed['embed_url']);
        $this->assertStringContainsString('autoplay=1', $embed['embed_url']);
        $this->assertStringContainsString('dnt=1', $embed['embed_url']);
        $this->assertStringNotContainsString('background=1', $embed['embed_url']);
    }
}
