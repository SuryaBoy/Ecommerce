<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->call([
			UsersTableSeeder::class,
			AdminTableSeeder::class,
			CategorySeeder::class,
			SubCategorySeeder::class,
			BrandSeeder::class,
			ProductsTableSeeder::class,
			PermissionSeeder::class,
		]);
    }
}
