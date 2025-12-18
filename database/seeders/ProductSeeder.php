<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'url_img' => 'https://example.com/img/shirt1.jpg',
                'name' => 'Camisa Básica Branca',
                'category' => 'Camisas',
                'size' => 'M',
                'price' => 49.90,
                'station' => 'Verão',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url_img' => 'https://example.com/img/shirt2.jpg',
                'name' => 'Camisa Social Azul',
                'category' => 'Camisas',
                'size' => 'G',
                'price' => 89.90,
                'station' => 'Outono',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url_img' => 'https://example.com/img/pants1.jpg',
                'name' => 'Calça Jeans Slim',
                'category' => 'Calças',
                'size' => '42',
                'price' => 129.90,
                'station' => 'Inverno',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url_img' => 'https://example.com/img/dress1.jpg',
                'name' => 'Vestido Floral',
                'category' => 'Vestidos',
                'size' => 'P',
                'price' => 159.90,
                'station' => 'Primavera',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url_img' => 'https://example.com/img/jacket1.jpg',
                'name' => 'Jaqueta de Couro',
                'category' => 'Jaquetas',
                'size' => 'M',
                'price' => 299.90,
                'station' => 'Inverno',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url_img' => 'https://example.com/img/tshirt1.jpg',
                'name' => 'Camiseta Estampada',
                'category' => 'Camisetas',
                'size' => 'G',
                'price' => 39.90,
                'station' => 'Verão',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url_img' => 'https://example.com/img/shorts1.jpg',
                'name' => 'Bermuda Cargo',
                'category' => 'Bermudas',
                'size' => '40',
                'price' => 79.90,
                'station' => 'Verão',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url_img' => 'https://example.com/img/sweater1.jpg',
                'name' => 'Suéter de Lã',
                'category' => 'Suéteres',
                'size' => 'M',
                'price' => 149.90,
                'station' => 'Inverno',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
