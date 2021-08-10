<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path','url','user_id'];


    public function getUrlPathAttribute(){
        return Storage::url($this->path);
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
