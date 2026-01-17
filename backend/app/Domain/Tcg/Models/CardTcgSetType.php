<?php

namespace App\Domain\Tcg\Models;

use Illuminate\Database\Eloquent\Model;

class CardTcgSetType extends Model
{
    protected $fillable = ['code', 'card_id', 'tcg_set_type_id', 'img_url', 'rarity_code'];
}
