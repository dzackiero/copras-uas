<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectsList extends Component
{
    // Search
    public $searchable = false;
    public $search = '';
    public $sortBy = 'created_at';

    public function render()
    {
        $projects = Project::search('name', $this->search)->where('isPrivate', false)->orderBy($this->sortBy, 'DESC')->get();
        return view('livewire.projects-list', [
            'projects' => $projects,
        ]);
    }
}
