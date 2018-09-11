<?php

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed test admin
        $seeded_name_gen = 'Admin_Admin_Admin';
        $user = User::where('name_gen', '=', $seeded_name_gen)->first();
        if ($user === null) {
            $user = User::create([
          'name_gen'      => 'Admin_Admin_Admin',
          'scout_name'    => 'Admin',
          'first_name'    => 'Admin',
          'last_name'     => 'Admin',
          'password'      => Hash::make('password'),
      ]);
            $user->save();
        }
        // Seed test user
        $user = User::where('name_gen', '=', 'User_User_User')->first();
        if ($user === null) {
            $user = User::create([
        'name_gen'    => 'User_User_User',
        'scout_name'  => 'Vento',
        'first_name'  => 'Caspar',
        'last_name'   => 'Brenneisen',
        'password'    => Hash::make('password'),
      ]);
            $user->save();
        }
    }
}
