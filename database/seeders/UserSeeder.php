<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define user data array
        $usersData = [
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'username' => 's_admin1',
                'password' => Hash::make('password'),
                'phone' => '08143238071',
                'email' => 's_admin1@panevents.com',
                'email_verified_at' => Carbon::now(),
                'role' => 'admin',
            ],
            [
                'first_name' => 'User',
                'last_name' => '1',
                'username' => 'user_1',
                'password' => Hash::make('password'),
                'phone' => '08143238071',
                'email' => 'user_1@panevents.com',
                'email_verified_at' => Carbon::now(),
                'role' => 'user',
            ],
            [
                'first_name' => 'User',
                'last_name' => '2',
                'username' => 'user_2',
                'password' => Hash::make('password'),
                'phone' => '08136593015',
                'email' => 'user_2@panevents.com',
                'email_verified_at' => Carbon::now(),
                'role' => 'user',
            ],
            [
                'first_name' => 'User',
                'last_name' => '3',
                'username' => 'user_3',
                'password' => Hash::make('password'),
                'phone' => '08136593015',
                'email' => 'user_3@panevents.com',
                'email_verified_at' => Carbon::now(),
                'role' => 'user',
            ],
        ];


        foreach ($usersData as $userData) {
            //Take the role and unset so the role won't be sent to user's table, cos there is no field there
            $role = $userData['role'];
            unset($userData['role']);

            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
            $user->assignRole($role);
        }

    }
}
