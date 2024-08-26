<?php

use App\Models\User;
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
        Schema::create('personalized_video_stores', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('title')->nullable();
             $table->string("categories")->nullable();
            $table->string('description')->nullable();
            $table->string('price')->nullable();
            $table->string('state')->nullable();
            $table->string("local_gov")->nullable();
            $table->string("productName")->nullable();
            $table->string('headlines')->nullable();
            $table->string('titleimage')->nullable();
            $table->string('itemadsid')->nullable();
            $table->string('otherimages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalized_video_stores');
    }
};
