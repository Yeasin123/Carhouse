<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $name = $this->faker->name;
        $slug = Str::slug($name);
        return [
            'brand_id' => function(){
                return Brand::get()->random();
            },
            'category_id' => function(){
                return Category::get()->random();
            },
            'subcategory_id' => function(){
                return SubCategory::get()->random();
            },
            'name' => $name,
            'image' => $this->faker->image(public_path('/images/product/'), 640, 480,null, false),
            'stock' => $this->faker->numberBetween($min = 1, $max = 20),
            'model' => Str::random(10),
            'color' => implode(', ', [$this->faker->colorName, $this->faker->colorName, $this->faker->colorName, $this->faker->colorName, $this->faker->colorName, $this->faker->colorName]),
            'price' => $this->faker->numberBetween($min = 200000, $max = 200000000),
            'year' => $this->faker->numberBetween($min = 2012, $max = 2021),
            'description' => $this->faker->paragraph,
            'slug' => $slug,
            'status' => 1
        ];
    }
}
