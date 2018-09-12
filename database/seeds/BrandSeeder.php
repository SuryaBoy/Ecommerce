<?php

use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$brands = array(
    		"LG",
		 	"Baltra", 
		 	"Apple", 
		 	"Nike", 
		 	"Godreg", 
		 	"Addidas",
		 	"BMC",
		 	"Himalayan",
		 	"Asus",
		 	"Star"
		 );
    	foreach($brands as $brand) {
    		factory(App\Brand::class,1)->create(
    			[
    				'name' => $brand,
					'slug' => str_slug($brand, '-')
    			]);
    	}
    }
}
