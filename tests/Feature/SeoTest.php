<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoTest extends TestCase
{
    public function test_homepage_includes_core_seo_tags(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertSee('<meta name="description"', false)
            ->assertSee('<link rel="canonical" href="http://localhost"', false)
            ->assertSee('<meta property="og:title"', false)
            ->assertSee('<meta name="twitter:card" content="summary_large_image">', false)
            ->assertSee('"@type":"AutoRepair"', false);
    }

    public function test_robots_txt_exposes_sitemap_location(): void
    {
        $response = $this->get('/robots.txt');

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Sitemap: http://localhost/sitemap.xml');
    }

    public function test_sitemap_xml_lists_the_homepage(): void
    {
        $response = $this->get('/sitemap.xml');

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<?xml version="1.0" encoding="UTF-8"?>', false)
            ->assertSee('<loc>http://localhost</loc>', false);
    }
}
