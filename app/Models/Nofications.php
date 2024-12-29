<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nofications extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function nofications(){
        return $this->belongsTo(User::class);
    }


}
