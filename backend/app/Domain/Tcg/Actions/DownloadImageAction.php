<?php

namespace App\Domain\Tcg\Actions;

use Illuminate\Support\Facades\Storage;

class DownloadImageAction
{
    public function execute(string $url, $folder): string|null
    {
        try {
            $contents = @file_get_contents($url); // @ suprime warning

            if ($contents === false) {
                return null;
            }

            $filename = $folder . '/' . basename($url);
            Storage::disk('public')->put($filename, $contents);

            return $filename;

        } catch (\Exception $e) {
            return null;
        }
    }
}
