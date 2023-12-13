<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenRequest;
use App\Models\UrlMapping;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ShortenController extends Controller
{
    public function create(): View|Factory
    {
        // Fetch all URL mappings for debugging
        $urlMappings = DB::table('url_mappings')->get();

        return view('shorten-url', compact('urlMappings'));
    }

    public function store(ShortenRequest $request): RedirectResponse
    {
        $existingMapping = UrlMapping::where('original_url', $request->input('original_url'))->first();

        if($existingMapping) {
            return redirect()->route('shorten.create')->with('error', 'URL already shortened')->withInput();
        }

        // Generate a unique short URL
        $shortUrl = $this->generateUniqueShortUrl();

        // Store the mapping in the database
        UrlMapping::create([
            'original_url' => $request->input('original_url'),
            'short_url' => $shortUrl,
        ]);

        return redirect()->route('shorten.create')
                            ->with('success', 'URL shortened successfully')
                            ->with('shortUrl', $shortUrl);
    }

    /**
         * Generate a unique short URL.
         *
         * @return string
         */
    private function generateUniqueShortUrl(): string
    {
        $maxAttempts = 5; // You can adjust this based on your needs
        $attempts = 0;

        do {
            $shortUrl = generateShortUrl();
            $existingMapping = DB::table('url_mappings')->where('short_url', $shortUrl)->first();

            $attempts++;
        } while ($existingMapping && $attempts < $maxAttempts);

        if ($attempts === $maxAttempts) {
            // Handle the case where a unique short URL couldn't be generated
            throw new \RuntimeException('Unable to generate a unique short URL');
        }

        return $shortUrl;
    }
}
