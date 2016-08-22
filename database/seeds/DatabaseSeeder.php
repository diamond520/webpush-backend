<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
		// $this->call('PusherTableSeeder');
        DB::table('pusher')->insert([
            'name' => 'diamond',
            'email' => 'diamond.cc@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
