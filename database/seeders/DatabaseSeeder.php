<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(5)->create();
        // Admin::factory(1)->create();
        // Brand::factory(5)->create();
        // Category::factory(5)->create();
        // SubCategory::factory(5)->create();
        Product::factory(5)->create();
    }
}
