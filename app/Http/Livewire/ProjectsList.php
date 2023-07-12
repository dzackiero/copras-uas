<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class ProjectsList extends Component
{
    // Search
    public $searchable = false;
    public $search = '';
    public $sortBy = 'created_at';
    public $user;

    public function render()
    {

        $query = Project::search('name', $this->search);

        if($this->user){
            $query->where('user_id', $this->user->id);
        }

        $projects = $query->where('isPrivate', false)->orderBy($this->sortBy, 'DESC')->paginate(5);

        return view('livewire.projects-list', [
            'projects' => $projects,
        ]);
    }
}
