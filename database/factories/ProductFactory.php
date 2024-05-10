<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imagePaths = [];

        // Generate storage paths for images
        for ($i = 1; $i <= 4; $i++) {
            $imagePath = storage_path('app/public/products/image_' . $i . '.jpg'); // Example storage path

            // Store image using file_put_contents
            file_put_contents($imagePath, file_get_contents('https://via.placeholder.com/500x500?text=Product+Image+' . $i));


            // Remove the path prefix before storing in $imagePaths
            $imagePaths[] = str_replace(storage_path('app/public/products/'), '', $imagePath);
        }

        return [
            'title' => $this->faker->name,
            'category_id'=>rand(1,5),
            'description' => $this->faker->sentence(45),
            'price' => $this->faker->randomNumber(2),
            'status' => $this->faker->boolean(),
            'images' => json_encode($imagePaths),
        ];
    }



}
