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

    function userProject($user) : View {
        $user = User::where('username', $user)->first();

        return view('user-project', [
            'user' => $user
        ]);
    }

}
