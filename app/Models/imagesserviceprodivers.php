<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imagesserviceprodivers extends Model
{
    use HasFactory;

    public function serviceprovider(){
        return $this->belongsTo(AdsServiceProvider::class);
    }
}
