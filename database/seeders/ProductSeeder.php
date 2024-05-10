<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the number of products you want to create
        $numberOfProducts = 3;

        // Create products using the factory
        \App\Models\Product::factory()->count($numberOfProducts)->create();
    }
}
