<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Admin::class,1)->create(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
            ]);
    }
}
