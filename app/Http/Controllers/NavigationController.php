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
        $projects = Project::all();
        return view('home', [
            'projects' =>  $projects,
        ]);
    }

    function userProjects($user) : View {
        $user = User::where('username', $user)->first();
        $projects = auth()->user() == $user ? $user->projects : $user->projects->where('isPrivate', false);

        return view('user-project', [
            'projects' =>  $projects,
            'user' => $user,
        ]);
    }

    function project($id) : View {
        $project = Project::find($id);
        if($project == null){
            return redirect()->route('home');
        }

        if($project->isPrivate && $project->user != auth()->user()){
            return redirect()->route('home');
        }

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
