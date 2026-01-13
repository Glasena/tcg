<?php

namespace App\Jobs;

use App\Domain\Tcg\Models\Card;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportSingleCardJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public array $cardData)
    {
    }

    public function handle(): void
    {
        try {
            $imagePath = null;

            if (isset($this->cardData['card_images'][0]['image_url'])) {
                $imagePath = $this->downloadImage(
                    $this->cardData['card_images'][0]['image_url']
                );
            }

            Card::updateOrCreate(
                ['tcg_custom_id' => $this->cardData['id']],
                [
                    'name' => $this->cardData['name'],
                    'tcg_type_id' => 1,
                    'img_url' => $imagePath,
                ]
            );

        } catch (\Exception $e) {
            \Log::error('Import failed', [
                'card' => $this->cardData['name'] ?? 'Unknown',
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function downloadImage(string $url): ?string
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