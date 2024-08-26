<?php

use App\Models\Apartment;
use App\Models\ItemsAds;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ItemfreeAds;
use App\Models\ShortLet;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ads_images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ItemsAds::class)->nullable();
            $table->foreignIdFor(ItemfreeAds::class)->nullable();
            

            $table->foreignIdFor(Apartment::class)->nullable();
            $table->foreignIdFor(ShortLet::class)->nullable();


            $table->string('itemadsimagesurls');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads_images');
    }
};
