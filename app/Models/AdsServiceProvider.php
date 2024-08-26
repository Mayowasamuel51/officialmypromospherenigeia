<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsServiceProvider extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function imagessserviceprovider(){
        return $this->hasMany(imagesserviceprodivers::class);
    }
}
