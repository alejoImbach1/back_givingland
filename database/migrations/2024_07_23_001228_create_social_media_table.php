<?php

use App\Models\SocialMedia;
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
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('name',45);
            $table->string('url');
        });

        SocialMedia::insert([
            [
                'name' => 'whatsapp',
                'url' => 'https://wa.me/57'
            ],
            [
                'name' => 'facebook',
                'url' => 'https://www.facebook.com/'
            ],
            [
                'name' => 'instagram',
                'url' => 'https://www.instagram.com/'
            ],
            [
                'name' => 'linkedin',
                'url' => 'https://co.linkedin.com/'
            ],
            [
                'name' => 'x-twitter',
                'url' => 'https://x.com/'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};
