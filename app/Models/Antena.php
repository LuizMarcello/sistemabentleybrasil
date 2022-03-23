<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antena extends Model
{
    use HasFactory;

    /* Modo massivo */
    protected $fillable = ['nome', 'imagem'];
}
