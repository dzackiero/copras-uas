<?php

namespace App\Http\Controllers;

use App\Models\AlternativeValue;
use App\Models\Criteria;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function show() : View {
        $user = Auth::user();

        $projects = $user->projects;
        return view('dashboard', [
            'projects' =>  $projects,
        ]);
    }

    function project($id) : View {
        $project = Project::find($id);

        $criterias = $project->criterias;
        $alternatives = $project->alternatives;

        $altenativeValue = AlternativeValue::all();

        return view('project-detail', [
            'project' =>  $project,
            'criterias' =>  $criterias,
            'alternatives' =>  $alternatives,
            'values' => $altenativeValue,
        ]);
    }
}
