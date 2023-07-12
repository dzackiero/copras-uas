<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class ProjectsList extends Component
{
    protected $listeners = ['new-project' => '$refresh'];

    // Search
    public $searchable = false;
    public $search = '';
    public $sortBy = 'created_at';
    public $user;

    public function render()
    {

        $query = Project::search('name', $this->search);

        if($this->user){
            $query = $query->where('user_id', $this->user->id);
        }

        if(!$this->user){
            $query = $query->where('isPrivate', false);
        }

        $projects = $query->orderBy($this->sortBy, 'DESC')->paginate(6);

        return view('livewire.projects-list', [
            'projects' => $projects,
        ]);
    }
}
