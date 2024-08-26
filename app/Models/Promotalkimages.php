<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotalkimages extends Model
{
    use HasFactory;

    
    protected $guarded = [];

    public function promotalk(){
        return $this->belongsTo(Promotalkdata::class);
    }

}
