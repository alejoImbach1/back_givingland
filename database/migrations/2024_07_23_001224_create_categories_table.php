<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('slug', 50)->unique()->nullable();
            // $table->timestamps();
        });
        Category::insert([
            [
                'name' => 'Electrónica',
            ],
            [
                'name' => 'Moda y accesorios',
            ],
            [
                'name' => 'Hogar y jardín',
            ],
            [
                'name' => 'Vehículos',
            ],
            [
                'name' => 'Inmuebles',
            ],
            [
                'name' => 'Deportes y ocio',
            ],
            [
                'name' => 'Coleccionables y arte',
            ],
            [
                'name' => 'Juegos y juguetes',
            ],
            [
                'name' => 'Salud y belleza',
            ]
        ]);
        $categories = Category::all();
        foreach ($categories as $category) {
            DB::table('categories')
                ->where('id', $category->id)
                ->update(['slug' => Str::slug($category->name)]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
