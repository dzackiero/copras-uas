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

        for ($i = 1; $i <= 3; $i++) {
            for ($j=1; $j <= 3; $j++) {
                AlternativeValue::factory()->create([
                    'criteria_id' => $j,
                    'alternative_id' => $i,
                ]);
            }
        }
        for ($i = 4; $i <= 6; $i++) {
            for ($j=4; $j <= 6; $j++) {
                AlternativeValue::factory()->create([
                    'criteria_id' => $j,
                    'alternative_id' => $i,
                ]);
            }
        }
        for ($i = 7; $i <= 9; $i++) {
            for ($j=7; $j <= 9; $j++) {
                AlternativeValue::factory()->create([
                    'criteria_id' => $j,
                    'alternative_id' => $i,
                ]);
            }
        }
    }
}
