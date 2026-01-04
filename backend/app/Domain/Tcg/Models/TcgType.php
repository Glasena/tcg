<?php

namespace App\Domain\Tcg\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TcgType extends Model
{
    /** @use HasFactory<\Database\Factories\TcgTypeFactory> */
    use HasFactory;

    protected $fillable = ['description'];

}
