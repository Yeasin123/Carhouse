<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubCategory::class;

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
            'category_id' => function(){
                return Category::get()->random();
            },
            'name' => $name,
            'image' => $this->faker->image(public_path('/images/subcategory/'), 640, 480,null, false),
            'slug' => $slug,
            'status' => 1,
        ];
    }
}
