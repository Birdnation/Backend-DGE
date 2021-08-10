<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function noticias(){
        return $this->hasMany('App\Models\Noticia');
    }

    public function eventos(){
        return $this->hasMany('App\Models\Evento');
    }

    public function anuncios(){
        return $this->hasMany('App\Models\Anuncio');
    }
}
