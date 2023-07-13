<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class EditProject extends Component
{
    public Project $project;
    public array $editedProject;
    public bool $editProjectModal = false;

    public function editProject() : void {
        $this->editedProject = $this->project->toArray();
        $this->editProjectModal = true;
    }

    public function updateProject() : void {
        $this->editProjectModal = false;
        $this->project->name = $this->editedProject['name'];
        $this->project->isPrivate = $this->editedProject['isPrivate'];
        $this->project->save();
    }

    public function render()
    {
        return view('livewire.edit-project');
    }
}
