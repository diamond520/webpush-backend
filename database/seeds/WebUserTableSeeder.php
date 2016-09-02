<?php

use Illuminate\Database\Seeder;

class WebUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\Models\WebUser::class, 9)->create();
    }
}
