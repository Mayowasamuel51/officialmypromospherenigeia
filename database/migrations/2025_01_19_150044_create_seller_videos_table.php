<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seller_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable();
            $table->string('categories')->nullable();
            $table->longText("titleImageurl")->nullable();
            $table->longText("titlevideourl")->nullable();
            $table->string("thumbnails")->nullable();
            $table->string("user_image")->nullable();
            $table->longText('description')->nullable();
            $table->string("user_name")->nullable();
         
            $table->string("state")->nullable();
            $table->string("local_gov")->nullable();
            
            $table->integer("freetimes")->default('0')->nullable();
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_videos');
    }
};
