<?php

namespace App\Console\Commands;

use App\Domain\Cards\Actions\ImportYugiohCardsAction;
use Illuminate\Console\Command;

class ImportYugiohCardsCommand extends Command
{
    protected $signature = 'cards:import-yugioh';
    protected $description = 'Import Yu-Gi-Oh cards from YGOProDeck API';

    public function handle(ImportYugiohCardsAction $action)
    {
        $this->info('Importing cards from YGOProDeck...');

        $total = $action->execute(fn($msg) => $this->line($msg)); // ← Callback

        $this->info("Finished Importing! Total: $total cards");
    }
}