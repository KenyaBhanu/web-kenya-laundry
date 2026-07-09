<?php

namespace Database\Seeders;

use App\Models\TypeOfService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeOfService::create([
            'service_name' => 'Wash',
            'price' => 4500,
        ]);
    }
}
