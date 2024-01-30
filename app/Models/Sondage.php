<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sondage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'question',
        'options', // Assurez-vous que 'options' est dans $fillable
        // ... autres champs ...
    ];

    protected $casts = [
        'options' => 'array', // Assurez-vous que 'options' est casté comme un tableau
        // ... autres casts ...
    ];
}
