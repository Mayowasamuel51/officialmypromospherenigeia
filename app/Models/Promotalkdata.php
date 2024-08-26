<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotalkdata extends Model
{
    use HasFactory;

        
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function talkimages(){
        return $this->hasMany(Promotalkimages::class);
    }

    public function comment(){
        return $this->hasMany(Promotalkcomment::class);
    }
}
