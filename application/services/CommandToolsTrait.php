<?php

namespace App\Services;

/**
 * Small helpers for console commands, unrelated to the DB: time, downloading images.
 * Requires $this->output()/$this->error() (available on Easysite\Library\Command).
 */
trait CommandToolsTrait
{
    protected function now(): string
    {
        return date('Y-m-d H:i:s');
    }

    /** '2026-08-21T19:00:00Z' -> '2026-08-21 19:00:00' (UTC). */
    protected function utc(string $iso): string
    {
        return gmdate('Y-m-d H:i:s', strtotime($iso));
    }

    /**
     * Downloads $url to $destinationPathWithoutExtension.<real extension> (not
     * always what you'd guess from the URL) and returns the FILENAME for a column
     * that stores it, or null on failure. Already-downloaded files are not
     * re-fetched, but the filename is still returned.
     */
    protected function downloadImage(?string $url, string $destinationPathWithoutExtension): ?string
    {
        if (empty($url)) {
            return null;
        }

        $extension = pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION) ?: 'png';
        $filename  = basename($destinationPathWithoutExtension) . '.' . $extension;
        $path      = $destinationPathWithoutExtension . '.' . $extension;

        if (file_exists($path)) {
            return $filename;
        }

        // some hosts (e.g. Wikimedia) return 403 without a User-Agent
        $context = stream_context_create(['http' => [
            'header' => "User-Agent: easysite-app/1.0\r\n",
        ]]);
        $contents = @file_get_contents($url, false, $context);
        if ($contents === false) {
            $this->error("failed to download {$url}");
            return null;
        }

        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (file_put_contents($path, $contents) === false) {
            $this->error("failed to write {$path}");
            return null;
        }
        $this->output('saved ' . $filename);

        return $filename;
    }
}
