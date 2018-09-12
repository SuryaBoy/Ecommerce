<?php

use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories = array(
    		"Electronics" => array("Smart Phones", "Mobile & Tablet Accessories", "Tablets", "Laptop"),
		 	"Women's Fashion" => array("Women's Shoes", "Women's Watch", "Women's Bags", "Women's Jewellery", "Women's Clothing"), 
		 	"Men's Fashion" => array("Men's Shoes", "Men's Watch", "Men's Bags", "Men's Jewellery", "Men's Clothing"), 
		 	"Sports" => array("Cricket", "Football", "Cycling", "Tennis", "Badminton"), 
		 	"Furniture" => array("Tables", "Chairs", "Wardrobe", "Vault"), 
		 	"Baby Toys & Kids" => array("Baby Clothing", "Baby Toys", "Baby Feedings"),
		 	"Grocery" => array("Tea", "Milk & Coffee", "Laundry Products", "Toilet Cleaner", "Pest Control"),
		 	"Beauty & Health" => array("Make Up", "Fragnences", "Skin Care", "Hair Color"),
		 	"Computing & Gaming" => array("Printers", "Storage Devices", "Video Gaming Consoles"),
		 	"Other" => array("Books & Stationary", "AutoMobiles", "Charity & Donation")
		 );
    	$index = 1;
    	foreach($categories as $category) {
    		foreach($category as $key => $sub_category) {
	    		factory(App\SubCategory::class,1)->create(
	    			[
	    				'name' => $sub_category,
						'slug' => str_slug($sub_category, '-'),
						'category_id' => $index,
	    			]);
    		}
    		$index++;
    	}
    }
}
