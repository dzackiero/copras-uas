<?php

namespace App\Http\Controllers;

use App\Models\AlternativeValue;
use App\Models\Criteria;
use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NavigationController extends Controller
{
    function show() : View {
        return view('home');
    }

    function userProject($user) : View {
        $user = User::where('username', $user)->first();
        $project = Project::firstOrCreate([
            'user_id' => $user->id,
        ]);

        if(!$project->criterias){
            Criteria::create([
                'project_id' => $project->id,
                'name' => 'Durability',
                'isBenefit' => True,
                'weight' => 5
            ]);
            Criteria::create([
                'project_id' => $project->id,
                'name' => 'Damage',
                'isBenefit' => True,
                'weight' => 5
            ]);
            Criteria::create([
                'project_id' => $project->id,
                'name' => 'Crowd Control',
                'isBenefit' => True,
                'weight' => 5
            ]);
            Criteria::create([
                'project_id' => $project->id,
                'name' => 'Difficulty',
                'isBenefit' => True,
                'weight' => 5
            ]);
        }

        return view('user-project', [
            'user' => $user
        ]);
    }

}
