<?php

namespace App\Http\Livewire;

use App\Models\Alternative;
use App\Models\AlternativeValue;
use App\Models\Criteria;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CoprasDetail extends Component
{
    protected $listeners = ['saved' => '$refresh'];

    public Project $project;
    public Collection $criterias;
    public Collection $alternatives;
    public Collection $alternativeValues;

    public Collection $criteriaTotals;

    // public function saved() {
    //     sleep(1);
    //     return redirect(request()->header('Referer'));
    // }

    public function loadDatas() {
        $this->criterias = Criteria::where('project_id', $this->project->id)->get();
        $this->alternatives = Alternative::where('project_id', $this->project->id)->get();

        $this->alternativeValues = AlternativeValue::whereIn('criteria_id', $this->criterias->pluck('id'))
        ->orWhereIn('alternative_id', $this->alternatives->pluck('id')->toArray())
        ->get();

        $this->criteriaTotals = AlternativeValue::selectRaw('criteria_id, sum(value) as total')->whereIn('criteria_id', $this->criterias->pluck('id'))
        ->orWhereIn('alternative_id', $this->alternatives->pluck('id')->toArray())
        ->groupBy('criteria_id')
        ->get();
    }

    public function render()
    {
        $this->loadDatas();

        return view('livewire.copras-detail');
    }
}
