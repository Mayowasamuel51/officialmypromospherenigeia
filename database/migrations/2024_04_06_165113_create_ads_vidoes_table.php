<?php

use App\Models\ItemsAdsvidoes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ItemfreeVideosAds;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ads_vidoes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ItemsAdsvidoes::class)->nullable();
            $table->string('itemadsvideos');
            $table->foreignIdFor(ItemfreeVideosAds::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads_vidoes');
    }
};
