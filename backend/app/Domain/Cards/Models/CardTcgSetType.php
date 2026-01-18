<?php

namespace App\Domain\Cards\Models;

use App\Domain\Tcg\Models\TcgSetType;
use Illuminate\Database\Eloquent\Model;

class CardTcgSetType extends Model
{
    protected $fillable = ['code', 'card_id', 'tcg_set_type_id', 'img_url', 'rarity_code'];

    public function tcgSetType()
    {
        return $this->belongsTo(TcgSetType::class);
    }

}
