<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoTweetcomment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function promotweetcomment(){
        return $this->belongsTo(PromoTweet::class);
    }
}
