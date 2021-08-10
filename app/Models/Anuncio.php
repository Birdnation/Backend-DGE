<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    use HasFactory;

    protected $fillable = [
        'texto',
        'area_id',
        'activo',
        'descripcion'
    ];

    public function area(){
        return $this->belongsTo('App\Models\Area');
    }
}
