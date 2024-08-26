<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsImages extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function itemads(){
        return $this->belongsTo(ItemsAds::class);
    }


    public function itemfreeads(){
        return $this->belongsTo(ItemfreeAds::class);
    }


    public function apartment(){
        return $this->belongsTo(Apartment::class);
    }


    public function shortlet(){
        return $this->belongsTo(ShortLet::class);
    }



    

}
