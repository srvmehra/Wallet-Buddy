<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'title' => 'Yamaha Acoustic Guitar',
                'sku' => 'GTR-001',
                'description' => 'Beginner friendly acoustic guitar',
                'price' => 8999,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Casio Digital Piano',
                'sku' => 'PNO-001',
                'description' => '88 key digital piano for practice and live sessions',
                'price' => 28999,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Roland Electronic Drum Kit',
                'sku' => 'DRM-001',
                'description' => 'Electronic drum kit with mesh pads',
                'price' => 45999,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Shure Vocal Microphone',
                'sku' => 'MIC-001',
                'description' => 'Professional microphone for vocals and recording',
                'price' => 6999,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Ibanez Bass Guitar',
                'sku' => 'BASS-001',
                'description' => '4 string bass guitar for live performances',
                'price' => 17999,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}