<?php

namespace Database\Seeders;

use App\Models\Alternative;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlternativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alternative::factory(3)->create([
            'project_id' => 1
        ]);
        Alternative::factory(3)->create([
            'project_id' => 2
        ]);
        Alternative::factory(3)->create([
            'project_id' => 3
        ]);
    }
}
