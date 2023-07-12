<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectsList extends Component
{
    use WithPagination;

    protected $listeners = ['new-project' => '$refresh'];

    // Search
    public $searchable = false;
    public $search = '';
    public $sortBy = 'updated_at';
    public $modifier = 'all';
    public $user;

    public function render()
    {

        $query = Project::search('name', $this->search);

        if($this->user){
            $query = $query->where('user_id', $this->user->id);

            if($this->user->id == auth()->user()->id){
                switch ($this->modifier) {
                    case 'private':
                        $query->where('isPrivate', true);
                        break;
                    case 'public':
                        $query->where('isPrivate', false);
                        break;
                    default:
                        break;
                }
            }
        }

        if(!$this->user){
            $query->where('isPrivate', false);
        }
        $projects = $query->orderBy($this->sortBy, 'DESC')->paginate(6);

        return view('livewire.projects-list', [
            'projects' => $projects,
        ]);
    }
}
