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
        Schema::create('cloths', function (Blueprint $table) {
            $table->id();;
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
            $table->string("brand")->nullable();
            $table->string("type")->nullable();
            $table->string("auto_manuel")->nullable();
            $table->string("engine_condition")->nullable();
            $table->string("condition_assessment")->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloths');
    }
};
