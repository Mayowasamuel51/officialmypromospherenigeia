<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarSales extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function carsalesimages(){
        return $this->hasMany(AdsImages::class);
    }

    public function feedsback(){
        return $this->hasMany(FeedBack::class);
    }
}
