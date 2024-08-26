<?php

use App\Models\ItemfreeAds;
use App\Models\ItemfreeVideosAds;
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
        Schema::create('feed_backs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ItemfreeAds::class)->nullable();
            $table->foreignIdFor(ItemfreeVideosAds::class)->nullable();
            $table->string("name")->nullable();
            $table->string("message")->nullable();
            $table->string("likes")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_backs');
    }
};
