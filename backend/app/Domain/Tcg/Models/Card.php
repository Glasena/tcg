<?php

namespace App\Domain\Tcg\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $tcg_custom_id
 * @property int $tcg_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $img_url
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card whereTcgCustomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card whereTcgTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Card extends Model
{
    protected $fillable = ['name', 'tcg_custom_id', 'tcg_type_id', 'img_url'];
}
