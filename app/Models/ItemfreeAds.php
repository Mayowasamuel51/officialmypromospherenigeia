<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;

class ItemfreeAds extends Model
{
    use HasFactory;
    // use Searchable;
    
    protected $guarded = [];

    public function user(){

        return $this->belongsTo(User::class);
    }
    // public function searchableAs(): string
    // {
    //     return 'categories';
    // }
    // public function toSearchableArray(): array
    // {
    //     $array = $this->toArray();
 
    //     // Customize the data array...
 
    //     return $array;
    // }
    
    public function adsimages(){
        return $this->hasMany(AdsImages::class);
    }

    public function feedsback(){
        return $this->hasMany(FeedBack::class);
    }
}
