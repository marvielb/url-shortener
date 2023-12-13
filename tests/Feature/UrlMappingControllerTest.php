<?php

namespace Tests\Feature;

use App\Models\UrlMapping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UrlMappingControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use WithoutMiddleware;

    public function testRedirectToOriginalUrl(): void
    {
        // Create a test URL mapping
        $urlMapping = UrlMapping::factory()->create();

        // Visit the short URL and assert redirection
        $response = $this->get("/{$urlMapping->short_url}");

        $response->assertRedirect($urlMapping->original_url);
    }

    public function testRedirectToNotFoundForInvalidShortUrl(): void
    {
        // Visit an invalid short URL and assert a 404 response
        $response = $this->get('/invalid-short-url');

        $response->assertStatus(404);
    }
}
