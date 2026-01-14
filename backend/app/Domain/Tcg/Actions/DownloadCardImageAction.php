<?php

namespace App\Domain\Tcg\Actions;

use Illuminate\Support\Facades\Storage;

class DownloadCardImageAction
{
    public function execute(string $url): string|null
    {
        try {
            $contents = @file_get_contents($url); // @ suprime warning

            if ($contents === false) {
                return null;
            }

            $filename = 'cards/' . basename($url);
            Storage::disk('public')->put($filename, $contents);

            return $filename;

        } catch (\Exception $e) {
            return null;
        }
    }
}
