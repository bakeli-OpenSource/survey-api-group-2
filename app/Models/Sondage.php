<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Casts\Attribute;

class Sondage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'titre',
        'option',
        'utilisateur_id'
    ];
    
    public function sondages()
{
    return $this->hasMany(Sondage::class);
}

    // protected function option(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => json_decode($value, true),
    //         set: fn ($value) => json_encode($value),
    //     );
    // }
    
}
