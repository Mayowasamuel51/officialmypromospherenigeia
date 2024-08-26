<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function itemsads(){
        return $this->belongsTo(ItemsAds::class);
    }

    public function itemsadsvidoes(){
        return $this->belongsTo(ItemsAdsvidoes::class);
    }

    public function serviceprodivers(){
        return $this->belongsTo(AdsServiceProvider::class);
    }
}
