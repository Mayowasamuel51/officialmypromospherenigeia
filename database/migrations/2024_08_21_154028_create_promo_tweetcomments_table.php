<?php

use App\Http\Controllers\PromoTweet;
use App\Models\PromoTweet as ModelsPromoTweet;
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
        Schema::create('promo_tweetcomments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ModelsPromoTweet::class)->nullable();
            $table->string("name")->nullable();
            $table->string("comment")->nullable();
            $table->string("likes")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_tweetcomments');
    }
};
