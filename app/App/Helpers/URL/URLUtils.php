<?php

namespace App\App\Helpers\URL;

class URLUtils
{
    /**
     * function unparseUrl
     *
     * @param array $parsedUrl
     * @return string
     */
    public static function unparseUrl(array $parsedUrl): string
    {
        $scheme   = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
        $host     = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        $port     = isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '';
        $user     = isset($parsedUrl['user']) ? $parsedUrl['user'] : '';
        $pass     = isset($parsedUrl['pass']) ? ':' . $parsedUrl['pass'] : '';
        $pass     = ($user || $pass) ? "{$pass}@" : '';
        $path     = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
        $query    = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';
        $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';

        return "{$scheme}{$user}{$pass}{$host}{$port}{$path}{$query}{$fragment}";
    }

    /**
     * function addQueryStringToUrl
     *
     * @param string $currentUrl
     * @param array $newQueryStrings
     *
     * @return string
     */
    public static function addQueryStringToUrl(string $currentUrl, array $newQueryStrings): string
    {
        $parsedUrl = parse_url($currentUrl);
        parse_str(($parsedUrl['query'] ?? ''), $currentQueries);

        $newQueries = $currentQueries ?? [];

        foreach ($newQueryStrings as $key => $value) {
            if (\is_integer($key) && \is_string($value)) {
                $key = $value;
                $value = '';
            }

            $newQueries[$key] = $value ?? '';
        }

        $parsedUrl['query'] = \http_build_query($newQueries);

        $newUrl = static::unparseUrl($parsedUrl);
        $newUrl = trim($newUrl, '\t\n\r\0\x0B\ \?\=');

        return $newUrl ?? $currentUrl;
    }

    /**
     * function mergeQueryString
     *
     * @param string $currentUrl
     * @param array $newQueryStrings
     *
     * @return string
     */
    public static function mergeQueryString(string $currentUrl = '', ?array $newQueryStrings = []): string
    {
        $newQueryStrings ??= [];

        return static::addQueryStringToUrl($currentUrl, $newQueryStrings);
    }
}
