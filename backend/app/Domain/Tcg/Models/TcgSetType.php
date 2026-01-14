<?php

namespace App\Domain\Tcg\Models;

use Illuminate\Database\Eloquent\Model;

class TcgSetType extends Model
{
    protected $fillable = ['tcg_type_id', 'name', 'code'];

    public function tcgType()
    {
        return $this->belongsTo(TcgType::class);
    }

}
