<?php

namespace App\Console\Commands;

use App\Domain\Tcg\Actions\DeleteAllCardTcgSetTypesAction;
use App\Domain\Tcg\Actions\ImportYugiohCardSetsAction;
use Illuminate\Console\Command;

class ImportYugiohSetsCommand extends Command
{
    protected $signature = 'sets:import-yugioh';
    protected $description = 'Import Yu-Gi-Oh sets from YGOProDeck API';

    public function handle(ImportYugiohCardSetsAction $importYugiohCardSetsAction, DeleteAllCardTcgSetTypesAction $deleteAllCardTcgSetTypesAction)
    {
        $this->info('Importing sets from YGOProDeck...');

        $deleteAllCardTcgSetTypesAction->execute();

        $total = $importYugiohCardSetsAction->execute(fn($msg) => $this->line($msg)); // ← Callback

        $this->info("Finished Importing! Total: $total sets");
    }
}