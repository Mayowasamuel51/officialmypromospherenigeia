<?php

use App\Models\Promotalkdata;
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
        Schema::create('promotalkcomments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Promotalkdata::class)->nullable();
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
        Schema::dropIfExists('promotalkcomments');
    }
};
