<?php

use App\Models\AdsServiceProvider;
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
        Schema::create('imagesserviceprodivers', function (Blueprint $table) {
            $table->id();
            $table->string("serviceimages")->nullable();
            $table->foreignIdFor(AdsServiceProvider::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagesserviceprodivers');
    }
};
