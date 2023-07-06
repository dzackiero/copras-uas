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

    // Criteria
    public bool $editCriteriaModal = false;
    public array $editedCriteria;

    // Alternative
    public bool $editAlternativeModal = false;
    public array $editedAlternative;

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

    public function addCriteria() : void {
        Criteria::create([
            'project_id' => $this->project->id,
            'name' => 'New Criteria',
            'isBenefit' => 0,
            'weight' => 1,
        ]);
    }

    public function editCriteria($id) : void {
        $this->editCriteriaModal = true;
        $this->editedCriteria = $this->criterias->firstWhere('id', $id)->toArray();
    }

    public function updateCriteria() : void {
        Criteria::find($this->editedCriteria['id'])->update($this->editedCriteria);
        $this->editCriteriaModal = false;
    }

    public function deleteCriteria($id) : void {
        AlternativeValue::where('criteria_id', $id)->delete();
        Criteria::destroy($id);

        $this->editCriteriaModal = false;

        $this->notification([
            'icon' => 'success',
            'title' => 'Criteria has been!',
            'timeout' => 4000,
        ]);
    }

    public function addAlternative() : void{
        Alternative::create([
            'project_id' => $this->project->id,
            'name' => 'New Alternative',
        ]);
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
        $alt = AlternativeValue::where('alternative_id', $id)->delete();
        Alternative::destroy($id);
    }

    public function save() : void {
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
            'title' => 'Data has been Saved Successfully!',
            'timeout' => 4000,
        ]);
    }

}
