<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Storage::deleteDirectory('public/posts_images');
        
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->enum('purpose',['d','i']);
            $table->string('expected_item',100)->nullable();
            $table->string('description');
            $table->boolean('reported')->default(0);
            $table->boolean('banned')->default(0);
            $table->integer('user_post_index',false,true)->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
