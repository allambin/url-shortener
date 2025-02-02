<?php

namespace App\Services;

use App\Models\Url;

class UrlService
{
    /**
     * Find the Url model from its alias
     *
     * @param $alias
     * @return Url
     */
    public function findUrlFromAlias($alias): Url
    {
        return Url::where('alias', $alias)->firstOrFail();
    }

    /**
     * Find the Url model from the short url
     *
     * @param $shortUrl
     * @return Url
     */
    public function findUrlFromShortUrl($shortUrl): Url
    {
        $path = parse_url($shortUrl, PHP_URL_PATH);
        $alias = trim($path, '/');
        return $this->findUrlFromAlias($alias);
    }

    /**
     * Create a new Url entity
     *
     * @param $url
     * @return Url
     */
    public function createUrl($url): Url
    {
        do {
            $alias = $this->generateRandomAlias();
        } while (Url::where('alias', $alias)->exists());

        return Url::create([
            'url' => $url,
            'alias' => $alias,
        ]);
    }

    /**
     * Generate a random string for an alias
     *
     * @param int $length
     * @return string
     */
    public function generateRandomAlias(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
