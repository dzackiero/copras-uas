<?php

namespace Database\Seeders;

use App\Models\Criteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Criteria::factory(3)->create([
            'project_id' => 1,
        ]);

        Criteria::factory(3)->create([
            'project_id' => 2,
        ]);

        Criteria::factory(3)->create([
            'project_id' => 3,
        ]);
    }
}
