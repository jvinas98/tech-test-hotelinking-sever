<?php

use Illuminate\Database\Seeder;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offer')->insert([
            'title' => '2X1 Neumáticos',
            'description' => 'Obtén esta oferta y podrás comprar dos neumáticos al precio de uno.',
            'price' => 54.45,
        ]);

        DB::table('offer')->insert([
            'title' => 'Viaje a Madrid',
            'description' => 'Viaja a madrid con nuestro irresistible precio.',
            'price' => 30.99,
        ]);


        DB::table('offer')->insert([
            'title' => 'Ofertón en electrodomésticos',
            'description' => 'Presenta este cupón y obtendrás un 20% de descuento en todos nuestros electrodomésticos.',
            'price' => 0.00,
        ]);

        DB::table('offer')->insert([
            'title' => 'SOLO HOY oferta PS4',
            'description' => 'Llevate una PS4 a precio de risa.',
            'price' => 99.99,
        ]);

        DB::table('offer')->insert([
            'title' => 'Colchón Visco Royal Top Confort',
            'description' => 'El colchón ideal para ofrecerte un confort y descanso óptimos.',
            'price' => 89.99,
        ]);

        DB::table('offer')->insert([
            'title' => 'Dos entradas de SPA con masaje',
            'description' => 'Relajate en nuestras piscinas y disfruta de unos masajes únicos, sal como nuevo de nuestro SPA.',
            'price' => 39.95,
        ]);

    }
}
