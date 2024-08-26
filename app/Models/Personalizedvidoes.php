<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personalizedvidoes extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function personal(){
        return $this->belongsTo(Personalizeds::class);
    }

}
