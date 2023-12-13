<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShortenControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test the store method in ShortenController.
     *
     * @return void
     */
    public function test_store_method_success(): void
    {
        $response = $this->post(route('shorten.store'), [
            'original_url' => 'https://example.com',
        ]);

        $response->assertRedirect(route('shorten.create'))
                 ->assertSessionHas('success')
                 ->assertSessionHas('shortUrl');
    }

    /**
     * Test the store method with validation error.
     *
     * @return void
     */
    public function test_store_method_validation_error(): void
    {
        $response = $this->post(route('shorten.store'), [
            'original_url' => 'invalid-url',
        ]);

        $response->assertRedirect(route('shorten.create'))
                 ->assertSessionHasErrors('original_url');
    }

}
