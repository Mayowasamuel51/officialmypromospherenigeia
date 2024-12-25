<?php

namespace App\Models;

use App\Http\Controllers\API\PromoTalkLikeController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function likestalks(){
        return $this->hasMany(Promotalkdata::class);
    }
}
