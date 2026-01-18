<?php

namespace App\Domain\Tcg\Models;
use App\Domain\Cards\Models\Card;
use App\Domain\Cards\Models\CardTcgSetType;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $tcg_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Tcg\Models\TcgType $tcgType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgSetType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgSetType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgSetType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgSetType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgSetType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgSetType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgSetType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgSetType whereTcgTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TcgSetType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TcgSetType extends Model
{
    protected $fillable = ['tcg_type_id', 'name', 'code', 'img_url', 'num_of_cards', 'date'];

    public function tcgType()
    {
        return $this->belongsTo(TcgType::class);
    }

    public function cardTcgSetTypes()
    {
        return $this->hasMany(CardTcgSetType::class, 'tcg_type_id');
    }

    public function cards()
    {
        return $this->hasManyThrough(
            Card::class,
            CardTcgSetType::class,
            'tcg_type_id',  // FK em card_tcg_set_type
            'id',          // PK em cards
            'id',           // PK em tcg_set_types
            'card_id' // FK em card_tcg_set_type
        );
    }

}
