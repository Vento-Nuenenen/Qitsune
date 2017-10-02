<?php

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $profile = new Profile();
        $adminRole = Role::whereName('Admin')->first();
        $userRole = Role::whereName('User')->first();

        // Seed test admin
        $seededNameGen = 'Admin_Admin_Admin';
        $user = User::where('name_gen', '=', $seededNameGen)->first();
        if ($user === null) {
            $user = User::create([
                'scoutname'                      => 'Admin',
                'first_name'                     => 'Admin',
                'last_name'                      => 'Admin',
                'name_gen'                       => 'Admin_Admin_Admin',
                'password'                       => Hash::make('password'),
                'token'                          => str_random(64),
                'activated'                      => true,
                'signup_confirmation_ip_address' => $faker->ipv4,
                'admin_ip_address'               => $faker->ipv4,
            ]);

            $user->profile()->save($profile);
            $user->attachRole($adminRole);
            $user->save();
        }

        // Seed test user
        $user = User::where('name_gen', '=', 'Test_Test_Test')->first();
        if ($user === null) {
            $user = User::create([
                'scoutname'                      => 'User',
                'first_name'                     => 'User',
                'last_name'                      => 'User',
                'name_gen'                       => 'User_User_User',
                'password'                       => Hash::make('password'),
                'token'                          => str_random(64),
                'activated'                      => true,
                'signup_ip_address'              => $faker->ipv4,
                'signup_confirmation_ip_address' => $faker->ipv4,
            ]);

            $user->profile()->save(new Profile());
            $user->attachRole($userRole);
            $user->save();
        }
    }
}
