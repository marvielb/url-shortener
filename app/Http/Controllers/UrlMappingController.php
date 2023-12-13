<?php

namespace App\Http\Controllers;

use App\Models\UrlMapping;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class UrlMappingController extends Controller
{
    /**
     * Redirect to the original URL based on the short URL.
     *
     * @param  string  $shortUrl
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect($shortUrl): RedirectResponse
    {
        // Attempt to fetch from cache
        $originalUrl = Cache::remember("short_url_{$shortUrl}", now()->addMinutes(5), function () use ($shortUrl) {
            // Find the mapping based on the short URL
            $urlMapping = UrlMapping::where('short_url', $shortUrl)->first();

            return $urlMapping ? $urlMapping->original_url : null;
        });

        if ($originalUrl) {
            // Redirect to the original URL
            return redirect()->away($originalUrl);
        }

        // Handle the case where the short URL is not found
        abort(404, 'Short URL not found');
    }
}
