<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Externalinfo extends Model
{
    use HasFactory;

     protected $guarded = [];

     public function sellervideos (){
        return $this->belongsTo(User::class);
    }

}
