<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'cuerpo',
        'imagen',
        'desc_imagen',
        'area_id',
        'user_id',
        'inicio',
        'fin',
        'color',
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
