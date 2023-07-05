<?php

namespace App\Http\Livewire;

use App\Models\Alternative;
use App\Models\AlternativeValue;
use App\Models\Criteria;
use Livewire\Component;

class ProjectTable extends Component
{

    public $project;
    public $criterias;
    public $alternatives;
    public $values;

    public function render()
    {

        $this->criterias = Criteria::where('project_id', $this->project->id)->get();
        $this->alternatives = Alternative::where('project_id', $this->project->id)->get();

        $this->values = AlternativeValue::whereIn('criteria_id', $this->criterias->pluck('id'))
        ->orWhereIn('alternative_id', $this->alternatives->pluck('id')->toArray())
        ->get();

        return view('livewire.project-table');
    }

    public function addCriteria() : void {
        Criteria::create([
            'project_id' => $this->project->id,
            'name' => 'C-TEST',
            'isBenefit' => 0,
            'weight' => 1,
        ]);
    }

    public function deleteCriteria($id) : void {
        AlternativeValue::where('criteria_id', $id)->delete();

        Criteria::destroy($id);
    }

    public function addAlternative() : void{
        Alternative::create([
            'project_id' => $this->project->id,
            'name' => 'New Alternative',
        ]);
    }

    public function deleteAlternative($id) : void {
        AlternativeValue::where('criteria_id', $id)->delete();

        Alternative::destroy($id);
    }


}
