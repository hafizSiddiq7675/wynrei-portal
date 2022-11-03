<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Exception;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {

            User::truncate();

            $user = new User();
            $user->name = "Super Admin";
            $user->email = "s@gmail.com";
            $user->phone = "123456789";
            $user->password = Hash::make('password');
            $user->email_verified_at = Carbon::now()->toDateTimeString();
            $user->save();


            $user = new User();
            $user->name = "Buyer";
            $user->email = "buyer@gmail.com";
            $user->phone = "123456789";
            $user->password = Hash::make('password');
            $user->email_verified_at = Carbon::now()->toDateTimeString();
            $user->save();


            $user = new User();
            $user->name = "Agent";
            $user->email = "agent@gmail.com";
            $user->phone = "123456789";
            $user->password = Hash::make('password');
            $user->email_verified_at = Carbon::now()->toDateTimeString();
            $user->save();



        } catch (Exception $e) {

            return $e->getMessage();
        }
    }
}
