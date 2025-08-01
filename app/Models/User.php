<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    //  protected $guarded= [];











    protected $fillable = [
        'name',
        'email',
        'role',
    'amount',
        // 'id_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function itemuserimages(){
        return $this->hasMany(ItemfreeAds::class);
    }

   

    public function itemuserivideo(){
        return $this->hasMany(ItemfreeVideosAds::class);
    }

    /// categories
    public function apartment(){
        return $this->hasMany(Apartment::class);
    }
    public function shortlet(){
        return $this->hasMany(ShortLet::class);
    }

    public function nofications(){
        return $this->hasMany(Nofications::class);
    }
    public function sellervideos (){
        return $this->hasMany(SellerVideos::class);
    }



    public function externalinfo(){
         return $this->hasMany(Externalinfo::class);
    }
}
