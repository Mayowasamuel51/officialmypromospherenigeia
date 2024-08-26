<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoTweet extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tweetimages(){
        return $this->hasMany(PromoTweetimages::class);
    }

    public function tweetcomment(){
        return $this->hasMany(PromoTweetcomment::class);
    }
}
