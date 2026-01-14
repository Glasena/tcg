<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\DTOs\CreateTcgSetTypeData;
use App\Domain\Tcg\Models\TcgSetType;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CreateTcgSetTypeAction
{
    public function execute(CreateTcgSetTypeData $data): TcgSetType
    {
        return DB::transaction(function () use ($data) {

            $exists = TcgSetType::where('code', $data->code)
                ->where('tcg_type_id', $data->tcg_type_id)
                ->exists();

            if ($exists) {
                throw new RuntimeException('Tcg Set already exists.');
            }

            return TcgSetType::create([
                'name' => $data->name,
                'code' => $data->code,
                'tcg_type_id' => $data->tcg_type_id,
            ]);
        });
    }
}
