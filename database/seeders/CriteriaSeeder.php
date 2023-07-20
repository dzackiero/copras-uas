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
        Criteria::factory()->create([
            'name' => 'Durability',
            'isBenefit' => True,
            'weight' => 5
        ]);
        Criteria::factory()->create([
            'name' => 'Damage',
            'isBenefit' => True,
            'weight' => 5
        ]);
        Criteria::factory()->create([
            'name' => 'Crowd Control',
            'isBenefit' => True,
            'weight' => 5
        ]);
        Criteria::factory()->create([
            'name' => 'Difficulty',
            'isBenefit' => False,
            'weight' => 5
        ]);
    }
}
