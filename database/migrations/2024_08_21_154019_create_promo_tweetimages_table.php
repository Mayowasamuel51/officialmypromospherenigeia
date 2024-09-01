<?php

use App\Models\PromoTweet;
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
        Schema::create('promo_tweetimages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PromoTweet::class)->nullable();
            $table->string('titleImageurl')->nullable();
            $table->string('itemadsimagesurls')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_tweetimages');
    }
};
