<?php

namespace App\Jobs;

use App\Domain\Tcg\Actions\CreateOrUpdateSetAction;
use App\Domain\Tcg\Actions\DownloadImageAction;
use App\Domain\Tcg\Models\Card;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportSingleSetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public array $setData)
    {
    }

    public function handle(
        CreateOrUpdateSetAction $createOrUpdateSetAction,
        DownloadImageAction $downloadCardImageAction
    ): void {
        try {
            $imagePath = null;

            if (isset($this->setData['set_image'])) {
                $imagePath = $downloadCardImageAction->execute(
                    $this->setData['set_image'],
                    'sets'
                );
            }

            $createOrUpdateSetAction->execute(
                new \App\Domain\Tcg\DTOs\CreateTcgSetTypeData(
                    tcg_type_id: Card::TYPE_YUGIOH,
                    name: $this->setData['set_name'],
                    code: $this->setData['set_code'],
                    num_of_cards: $this->setData['num_of_cards'],
                    date: Carbon::createFromFormat('Y-m-d', $this->setData['tcg_date']),
                    image: $imagePath,
                )
            );

        } catch (\Exception $e) {
            \Log::error('Import failed', [
                'set' => $this->setData['set_name'] ?? 'Unknown',
                'error' => $e->getMessage(),
            ]);
        }
    }
}