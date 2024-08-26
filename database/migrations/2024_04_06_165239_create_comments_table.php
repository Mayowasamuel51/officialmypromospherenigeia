<?php

use App\Models\AdsServiceProvider;
use App\Models\ItemfreeAds;
use App\Models\ItemfreeVideosAds;
use App\Models\ItemsAds;
use App\Models\ItemsAdsvidoes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ItemsAds::class);
            $table->foreignIdFor(ItemsAdsvidoes::class);
            $table->foreignIdFor(AdsServiceProvider::class);
            $table->foreignIdFor(ItemfreeAds::class);
            $table->foreignIdFor(ItemfreeVideosAds::class);
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
