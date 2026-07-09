<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminLevel = Level::where('level_name', 'Administrator')->first();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@laundry.com',
            'password' => Hash::make('12345678'),
            'id_level' => $adminLevel->id
        ]);
    }
}
