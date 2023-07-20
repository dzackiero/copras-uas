<?php

namespace App\Http\Livewire;

use App\Models\Alternative;
use App\Models\AlternativeValue;
use App\Models\Criteria;
use App\Models\Project;
use Livewire\Component;

class ProjectDetail extends Component
{
    public $user;
    public $project;
    public $criterias;
    public $alternatives;
    public $alternativeValues;

    public $modalAlternative = [];
    public $modalCriteria = [];

    public $ranking = [];

    public $CRITERIA_COUNT;

    // Modals
    public $addAlternativeModal = false;
    public $editAlternativeModal = false;
    public $editCriteriaModal = false;

    public function render()
    {
        $this->project = Project::find($this->user->project->id);
        $this->criterias = Criteria::where("project_id", $this->project->id)->get();
        $this->alternatives = Alternative::where("project_id", $this->project->id)->get();
        $this->alternativeValues = AlternativeValue::whereIn('criteria_id', $this->criterias->pluck('id'))->get();
        $this->CRITERIA_COUNT = $this->criterias->count();

        $this->moora();

        return view('livewire.project-detail');
    }

    public function addAlternative() {
        $alt = Alternative::create([
            'project_id' => $this->project->id,
            'name' => $this->modalAlternative['name'],
        ]);

        foreach($this->criterias as $i => $criteria){
            AlternativeValue::create([
                'alternative_id' => $alt->id,
                'criteria_id' => $criteria->id,
                'value' => $this->modalAlternative[$i+1],
            ]);
        }

        $this->modalAlternative = [];
        $this->addAlternativeModal = false;
    }

    public function editAlternative($id) {
        $alternative = Alternative::find($id);
        $this->modalAlternative['id'] = $id;
        $this->modalAlternative['name'] = $alternative->name;
        foreach($this->criterias as $i => $criteria){
            $this->modalAlternative[$i+1] = $alternative->alternative_values->where('criteria_id', 1)->first()->value;
        }

        $this->editAlternativeModal = true;
    }

    public function updateAlternative() {
        $alternative = Alternative::find($this->modalAlternative['id']);
        $alternative->name = $this->modalAlternative['name'];
        $alternative->save();

        foreach($this->criterias as $i => $criteria){
            $value = AlternativeValue::where('alternative_id', $alternative->id)
            ->where('criteria_id', $criteria->id)
            ->update(['value' => $this->modalAlternative[$i+1]]);
        }

        $this->modalAlternative = [];
        $this->editAlternativeModal = false;
    }

    public function deleteAlternative() {
        $alternative = Alternative::find($this->modalAlternative['id'])->delete();


        $this->modalAlternative = [];
        $this->editAlternativeModal = false;
    }

    public function editCriteria($id) {
        $criteria = Criteria::find($id);
        $this->modalCriteria['id'] = $id;
        $this->modalCriteria['name'] = $criteria->name;
        $this->modalCriteria['weight'] = $criteria->weight;

        $this->editCriteriaModal = true;
    }

    public function updateCriteria() {
        $criteria = Criteria::find($this->modalCriteria['id']);
        $criteria->weight = $this->modalCriteria['weight'];
        $criteria->save();

        $this->modalCriteria = [];
        $this->editCriteriaModal = false;
    }

    public function moora() {
        $matrix = [];
        $normalize_divider = [];
        $weight = [];
        $this->ranking = [];


        foreach ($this->criterias as $criteria) {
            $divider = $criteria->alternative_values->pluck('value')
            ->map(function ($item) {
                return $item*$item;
            })->sum();

            $normalize_divider[$criteria->id] = sqrt($divider);

            $weight[$criteria->id] = $criteria->weight / $this->criterias->sum('weight');
        }

        foreach ($this->alternatives as $alternative) {
            foreach ($this->criterias as $criteria) {
                $value = AlternativeValue::where('criteria_id', $criteria->id)
                ->where('alternative_id', $alternative->id)
                ->first()->value;
                $matrix[$alternative->id][$criteria->id] = $value / $normalize_divider[$criteria->id];
            }
        }

        $optimize = $matrix;

        foreach ($this->alternatives as $alternative) {
            foreach ($this->criterias as $criteria) {
                $isPlus = $criteria->isBenefit ? 1 : -1;
                $optimize[$alternative->id][$criteria->id] = $matrix[$alternative->id][$criteria->id] * $isPlus * $weight[$criteria->id];

            }
            $optimize[$alternative->id] = collect($optimize[$alternative->id])->sum();

            $this->ranking []= [
                'alternative' => $alternative->name,
                'value' => $optimize[$alternative->id],
            ];

        }
        $this->ranking = collect($this->ranking)->sortByDesc('value')->values();
    }
}
