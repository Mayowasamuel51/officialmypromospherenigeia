<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ItemfreeAds;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('others', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable();
            $table->string("discount")->nullable();
            $table->string("user_image")->nullable();
            $table->string("user_name")->nullable();
            $table->string("user_phone")->nullable();
            $table->string('whatapp')->nullable();
            $table->string('aboutMe')->nullable();
            $table->string("user_website")->nullable();
            $table->string("user_social")->nullable();
            $table->string("state")->nullable();
            $table->string("local_gov")->nullable();
            $table->string("description")->nullable();
            $table->string("price")->nullable();
            
            $table->string("titleImageurl")->nullable();
            $table->string('itemadsid')->nullable();
            $table->string("parking_space")->nullable();
            $table->string("type")->nullable();
            $table->string("rooms")->nullable();
            $table->string("max_guest")->nullable();
            $table->string("policy")->nullable();
            $table->string("house_rules")->nullable();
            $table->string("self_check_in")->nullable();
            $table->string("facilities")->nullable();
            $table->string("address")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('others');
    }
};
