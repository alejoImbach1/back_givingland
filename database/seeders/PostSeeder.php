<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()->count(30)->create();

        User::find(1)->posts()->createMany([
            [
                'name' => 'Rocola en forma de carro deportivo',
                'purpose' => 'intercambio',
                'expected_item' => 'Auriculares inalámbricos',
                'description' => 'Quiero intercambiar esta rocola por unos auriculares inalámbricos. La roca funciona perfectamente, solo tiene 2 años de uso.',
                'location_id' => 315,
                'category_id' => 1
            ],
            [
                'name' => 'Espejo para sala',
                'purpose' => 'donación',
                // 'expected_item' => 'Auriculares inalámbricos',
                'description' => 'Quiero donar este espejo con estética bonita, perfecto para decorar ambientes familiares.',
                'location_id' => 315,
                'category_id' => 3
            ],
            [
                'name' => 'Diademas alámbricas',
                'purpose' => 'intercambio',
                'expected_item' => 'Teclado para pc',
                'description' => 'Quiero intercambiar estas diademas, el micrófono no funciona, pero el sonido es de muy buena calidad. Deseo obtener un teclado para computadora a cambio, funcional',
                'location_id' => 315,
                'category_id' => 1
            ],
            [
                'name' => 'Libro Juego de Tronos',
                'purpose' => 'donación',
                // 'expected_item' => 'Auriculares inalámbricos',
                'description' => 'Quiero donar este libro (Juego de Tronos - George R.R Marin), el primer libro de la saga canción de hielo y fuego. En muy buena condición para un lector apasiado del universo de juego de tronos.',
                'location_id' => 315,
                'category_id' => 7
            ]
        ]);

        User::find(2)->posts()->createMany([
            [
                'name' => 'Mouse gamer inalámbrico',
                'purpose' => 'intercambio',
                'expected_item' => 'Maletín en buen estado',
                'description' => 'Quiero intercambiar este mouse inalámbrico. Funciona muy bien todavía, es recargable y con luces rgb. Me gustaría un maletín a cambio, para la universidad.',
                'location_id' => 1017,
                'category_id' => 1
            ],
            [
                'name' => 'Tarro de agua',
                'purpose' => 'donación',
                // 'expected_item' => 'Auriculares inalámbricos',
                'description' => 'Quiero donar este tarro de agua con accesorios.',
                'location_id' => 1017,
                'category_id' => 6
            ],
            [
                'name' => 'Casco deportivo',
                'purpose' => 'intercambio',
                'expected_item' => 'Celular de gama media; samsung, motorola o redmi',
                'description' => 'Quiero intercambiar este caso deportivo, está completamente nuevo, me lo gané en una rifa pero no poseo motocicleta. Me interesa intercambiarlo por un celular funcional para obsequiar a un familiar',
                'location_id' => 1017,
                'category_id' => 4
            ],
            [
                'name' => 'Medidor de peso digital portatil',
                'purpose' => 'intercambio',
                'expected_item' => 'Smartwatch',
                'description' => 'Quiero intercambiar este medidor de peso digital (en perfecto estado) por un reloj smartwatch no muy usado y moderno',
                'location_id' => 1017,
                'category_id' => 1
            ]
        ]);
    }
}
