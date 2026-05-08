<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash,DB;
class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $checkUser = User::where('email','superadmin@sembark.com')->first();
        if(!$checkUser){
            $user = User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@sembark.com',
                'email_verified_at' => now(),
                'password' => Hash::make('1234567890'),
            ]);
    
            $user->assignRole('SuperAdmin');
        }
        
    }
}
