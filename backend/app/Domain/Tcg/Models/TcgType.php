<?php

namespace App\Domain\Tcg\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TcgType extends Model
{
    /** @use HasFactory<\Database\Factories\TcgTypeFactory> */
    use HasFactory;

    protected $fillable = ['description'];

}
