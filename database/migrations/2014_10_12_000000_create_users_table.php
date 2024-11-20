<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('b_name')->unique();
            $table->string('avater')->nullable();
            $table->string("user_social")->nullable();
            $table->string('name')->nullable();
            $table->string('backgroundimage')->nullable();
            $table->string('google_id')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('whatapp')->nullable();
            $table->integer("freetimes")->default('0')->nullable();
            $table->string('date_buy_count')->integer()->nullable();
            $table->string('id_number')->nullable();
            $table->string('discount')->nullable();
            $table->string('current_plan')->default('freeplan')->nullable();
            $table->string('country')->nullable();
            $table->string('location')->nullable();
            $table->string('websiteName')->nullable();
            $table->string('brandName')->nullable();
            $table->string('messageCompany')->nullable();
            $table->string('aboutMe')->nullable();
            $table->string('profileImage')->nullable();
            $table->boolean('verified')->nullable()->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
