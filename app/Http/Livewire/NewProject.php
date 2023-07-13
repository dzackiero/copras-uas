<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NewProject extends Component
{
    public $title;
    public bool $newProjectModal = false;
    public array $newProject = ['isPrivate' => false];

    public function render()
    {
        return view('livewire.new-project');
    }

    public function addProject() {
        $project = Project::create([
            'user_id' => Auth::user()->id,
            'name' => $this->newProject['name'],
            'isPrivate' => $this->newProject['isPrivate'],
        ]);

        $this->newProject = ['isPrivate' => false];
        $this->newProjectModal = false;
        $this->emit('new-project');

        return redirect()->route('project-detail', $project->id);
    }
}
