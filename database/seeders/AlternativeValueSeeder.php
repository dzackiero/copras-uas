<?php

namespace Database\Seeders;

use App\Models\AlternativeValue;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlternativeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AlternativeValue::factory(20)->create([
            'criteria_id' => rand(1,3),
            'alternative_id' => rand(1,10)
        ]);
    }
}
