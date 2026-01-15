<?php

namespace App\Console\Commands;

use App\Domain\Tcg\Actions\ImportYugiohCardSetsAction;
use Illuminate\Console\Command;

class ImportYugiohSetsCommand extends Command
{
    protected $signature = 'sets:import-yugioh';
    protected $description = 'Import Yu-Gi-Oh sets from YGOProDeck API';

    public function handle(ImportYugiohCardSetsAction $action)
    {
        $this->info('Importing sets from YGOProDeck...');

        $total = $action->execute(fn($msg) => $this->line($msg)); // ← Callback

        $this->info("Finished Importing! Total: $total sets");
    }
}