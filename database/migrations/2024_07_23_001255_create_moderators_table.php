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
        Schema::create('moderators', function (Blueprint $table) {
            $table->id();
            $table->enum('type_id',['cc','ce']);
            $table->string('id_number',15);
            $table->string('name',45)->nullable();
            $table->string('email',45)->unique();
            $table->string('password'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moderators');
    }
};
