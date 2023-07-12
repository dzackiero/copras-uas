<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Project::factory(3)->create([
                "user_id" => 1,
                "isPrivate" => false,
                "name" => fake()->company()
            ]
        );

        Project::factory(10)->create();
    }
}
