<?php

use Illuminate\Database\Seeder;
use App\SubCategory;
use App\Brand;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$subcats = SubCategory::all();
    	foreach ($subcats as $subcat) {
    		for ($i = 0; $i < 10; $i++) {
    			factory(App\Product::class, 1)->create([
    				'sub_category_id' => $subcat->id,
    			]);
    		}
    	}
    }
}
