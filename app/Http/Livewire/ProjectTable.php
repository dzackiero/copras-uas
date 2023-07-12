<?php

namespace App\Http\Livewire;

use App\Models\Alternative;
use App\Models\AlternativeValue;
use App\Models\Criteria;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use WireUi\Traits\Actions;


class ProjectTable extends Component
{

    use Actions;

    public Project $project;
    public Collection $criterias;
    public Collection $alternatives;
    public Collection $alternativeValues;

    protected $listeners = ['validationError'];

    // Criteria
    public bool $editCriteriaModal = false;
    public bool $addCriteriaModal = false;
    public array $addedCriteria = ['isBenefit' => false];
    public array $editedCriteria = [];

    // Alternative
    public bool $addAlternativeModal = false;
    public bool $editAlternativeModal = false;
    public array $addedAlternative = [];
    public array $editedAlternative = [];

    public array $value = [];

    public function loadDatas() {
        $this->criterias = Criteria::where('project_id', $this->project->id)->get();
        $this->alternatives = Alternative::where('project_id', $this->project->id)->get();

        $this->alternativeValues = AlternativeValue::whereIn('criteria_id', $this->criterias->pluck('id'))
        ->orWhereIn('alternative_id', $this->alternatives->pluck('id')->toArray())
        ->get();
    }

    public function mount() {

        $this->loadDatas();

        foreach ($this->criterias as $criteria) {
            foreach ($this->alternatives as $alternative) {
                $this->value['crit-' . $criteria->id . '-alt-' . $alternative->id] = $this->alternativeValues->where('criteria_id', $criteria->id)->where('alternative_id', $alternative->id)->first()->value ?? 0;
            }
        }
    }

    public function render() {
        $this->loadDatas();

        return view('livewire.project-table');
    }

    protected function validating(string $type) : void {
        if($type == 'table'){
            $this->validate(
                [
                    'value.*' => 'required|min:0|numeric',
                ],
                [
                    'value.*.required' => 'Cell value(s) cannot be empty',
                    'value.*.min' => 'value(s) minimum is 0',
                    'value.*.numeric' => 'Cell value(s) has to be number',
                ]
            );
        }

        if($type == 'addedCriteria' || $type == 'editedCriteria'){
            $this->validate(
                [
                    "$type.name" => 'required',
                    "$type.isBenefit" => 'required',
                    "$type.weight" => 'required|integer|min:0|max:10',
                ],
                [
                    "$type.name.required" => 'Criteria NAME cannot be empty',
                    "$type.weight.required" => 'Criteria WEIGHT be empty',
                    "$type.weight.numeric" => 'weight has to be a number',
                    "$type.weight.*" => 'Weight is not in acceptable range (1-10)',
                ]
            );
        }
    }

    public function addCriteria() : void {
        $this->validating('addedCriteria');

        Criteria::create([
            'project_id' => $this->project->id,
            'name' => $this->addedCriteria['name'],
            'isBenefit' => $this->addedCriteria['isBenefit'],
            'weight' => $this->addedCriteria['weight'],
        ]);

        $this->addedCriteria = ['isBenefit' => false];
        $this->addCriteriaModal = false;
    }

    public function editCriteria($id) : void {
        $this->editCriteriaModal = true;
        $this->editedCriteria = $this->criterias->firstWhere('id', $id)->toArray();
    }

    public function updateCriteria() : void {
        $this->validating('editedCriteria');

        Criteria::find($this->editedCriteria['id'])->update($this->editedCriteria);
        $this->editCriteriaModal = false;
    }

    public function deleteCriteria($id) : void {
        AlternativeValue::where('criteria_id', $id)->delete();
        Criteria::destroy($id);

        $this->notification([
            'icon' => 'success',
            'title' => 'Criteria has been!',
            'timeout' => 4000,
        ]);

        $this->editCriteriaModal = false;
    }

    public function addAlternative() : void{
        Alternative::create([
            'project_id' => $this->project->id,
            'name' => $this->addedAlternative['name'],
        ]);
        $this->addedAlternative = [];
        $this->addAlternativeModal = false;
    }

    public function editAlternative($id) : void {
        $this->editAlternativeModal = true;
        $this->editedAlternative = $this->alternatives->firstWhere('id', $id)->toArray();
    }

    public function updateAlternative() : void {
        Alternative::find($this->editedAlternative['id'])->update($this->editedAlternative);
        $this->editAlternativeModal = false;
    }

    public function deleteAlternative($id) : void {
        AlternativeValue::where('alternative_id', $id)->delete();
        Alternative::destroy($id);

        $this->editAlternativeModal = false;
    }

    public function save() : void {

        $this->validating('table');
        foreach ($this->criterias as $criteria) {
            foreach ($this->alternatives as $alternative) {
                $alternativeValue =  AlternativeValue::firstOrNew([
                    'criteria_id' => $criteria->id,
                    'alternative_id' => $alternative->id,
                ]);
                $alternativeValue->value = $this->value['crit-'.$criteria->id.'-alt-'.$alternative->id] ?? 0;

                $alternativeValue->save();
            }
        }

        $this->notification([
            'icon' => 'success',
            'title' => 'Data has been saved successfully!',
            'timeout' => 4000,
        ]);

        $this->emit('saved');
        $this->project->touch();
    }

}
