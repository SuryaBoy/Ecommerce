<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories = array(
    		"Electronics",
		 	"Women's Fashion", 
		 	"Men's Fashion", 
		 	"Sports", 
		 	"Furniture", 
		 	"Baby Toys & Kids",
		 	"Grocery",
		 	"Beauty & Health",
		 	"Computing & Gaming",
		 	"Other"
		 );
    	foreach($categories as $category) {
    		factory(App\Category::class,1)->create(
    			[
    				'name' => $category,
					'slug' => str_slug($category, '-'),
    			]);
    	}
    }
}
