<?php

namespace App\Http\Controllers;

use App\Models\UrlMapping;
use Illuminate\Http\RedirectResponse;

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
        // Find the mapping based on the short URL
        $urlMapping = UrlMapping::where('short_url', $shortUrl)->first();

        if ($urlMapping) {
            // Redirect to the original URL
            return redirect()->away($urlMapping->original_url);
        }

        // Handle the case where the short URL is not found
        abort(404, 'Short URL not found');
    }
}
