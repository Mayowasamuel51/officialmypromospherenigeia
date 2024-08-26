<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personalizeds extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function personalizedimages(){
        return $this->hasMany(Personalizedimages::class);
    }


    public function personalizedvidoes(){
        return $this->hasMany(Personalizedvidoes::class);
    }
    
}
