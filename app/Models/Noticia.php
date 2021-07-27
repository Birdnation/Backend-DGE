<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'subtitulo',
        'cuerpo',
        'imagen',
        'desc-img',
        'area_id',
        'user_id',

    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function area(){
        return $this->belongsTo('App\Models\Area');
    }

    public function tags(){
        return $this->belongsToMany('App\Models\Tag');
    }
}
