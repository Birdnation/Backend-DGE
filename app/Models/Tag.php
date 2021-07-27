<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function eventos(){
        return $this->belongsToMany('App\Models\Evento');
    }

    public function noticias(){
        return $this->belongsToMany('App\Models\Noticia');
    }
}
