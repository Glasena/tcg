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

    const TYPE_YUGIOH = 1;

    protected $fillable = ['name', 'tcg_custom_id', 'tcg_type_id', 'img_url'];

    // Relacionamento 1: Acessa a tabela intermediária COM os dados extras
    public function cardTcgSetTypes()
    {
        return $this->hasMany(CardTcgSetType::class);
    }

    // Relacionamento 2: Pula a intermediária e vai direto pros TcgSetTypes
    public function tcgSetTypes()
    {
        return $this->hasManyThrough(
            TcgSetType::class,
            CardTcgSetType::class,
            'card_id',          // FK em card_tcg_set_type
            'id',              // PK em tcg_set_types
            'id',               // PK em cards
            'tcg_type_id' // FK em card_tcg_set_type
        );
    }


}
