<?php

use App\Models\Location;
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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('region', 100);
            $table->string('codigo_dane_departamento', 5);
            $table->string('departamento', 100);
            $table->string('codigo_dane_municipio', 10);
            $table->string('municipio', 100);
        });
        $data = array_map('str_getcsv', file(storage_path('app/default/departamentos_municipios.csv')));
        foreach ($data as $row) {
            Location::insert([
                'region' => $row[0],
                'codigo_dane_departamento' => $row[1],
                'departamento' => $row[2],
                'codigo_dane_municipio' => $row[3],
                'municipio' => $row[4],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
