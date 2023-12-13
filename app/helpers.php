<?php

if (!function_exists('generateShortUrl')) {
    /**
     * Generate a unique short URL.
     *
     * @param int $length
     * @return string
     */
    function generateShortUrl($length = 6)
    {
        // Your code to generate a unique short URL
        // This is a simplified example, and you might need a more robust solution
        return substr(md5(uniqid()), 0, $length);
    }
}
