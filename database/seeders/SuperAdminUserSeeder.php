<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Anwar', 
            'email' => 'aku@anwarhebat.com',
            'password' => Hash::make('password')
        ]);
    
        $role = Role::create(['name' => 'Super Admin']);
     
        $user->assignRole([$role->id]);
    }
}
