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
        Schema::create('apartments', function (Blueprint $table) {
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

            $table->string("titleImageurl")->nullable();
            $table->string('itemadsid')->nullable();
            $table->string("type")->nullable();
            $table->string("address")->nullable();
            $table->string("market_status")->nullable();
            $table->string("sale_rent")->nullable();
            $table->string("guide")->nullable();
            $table->string("price")->nullable();
            $table->string("lastupdated")->nullable();
            $table->string("bedroom")->nullable();







            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
