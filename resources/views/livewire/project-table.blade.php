<div class="space-y-4">
    {{-- Buttons --}}
    @if (auth()->user() == $project->user)
        <x-button wire:click="$toggle('addCriteriaModal')" label='Add Criteria' icon="plus" color="primary" />
        <x-button wire:click="$toggle('addAlternativeModal')" label='Add Alternative' color="primary" icon="plus" />
    @endif

    {{-- Table --}}
    @if ($criterias->isNotEmpty() || $alternatives->isNotEmpty())
        <div class="overflow-x-auto pb-2 soft-scrollbar">
            <table class="w-full text-center">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Alternative</th>
                        @foreach ($criterias as $criteria)
                            <th class="border px-4 py-2 min-w-[6rem]">
                                <div class="">{{ $criteria->name }}
                                    {{ $criteria->isBenefit ? '(Benefit)' : '(Cost)' }}
                                </div>
                                <x-button wire:click="editCriteria({{ $criteria->id }})" icon="pencil" />
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    <form wire:submit.prevent='save' id="valueForm">

                        @foreach ($alternatives as $alternative)
                            <tr>
                                <td class="border">
                                    <p>
                                        {{ $alternative->name }}
                                        <x-button wire:click="editAlternative({{ $alternative->id }})" icon="pencil" />
                                    </p>
                                </td>
                                @foreach ($criterias as $criteria)
                                    <td class="border">
                                        <input type="number" required placeholder="0" min="0"
                                            wire:key='{{ 'crit-' . $criteria->id . '-alt-' . $alternative->id }}'
                                            wire:model='value.{{ 'crit-' . $criteria->id . '-alt-' . $alternative->id }}'
                                            name="{{ 'crit-' . $criteria->id . '-alt-' . $alternative->id }}"
                                            class="border-none text-center w-full @error('value.crit-' . $criteria->id . '-alt-' . $alternative->id) bg-red-100 @enderror
                                        ">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        {{-- <tr>
                            <td class="border">Total</td>
                            @foreach ($criterias as $criteria)
                                <td class="border"><input type="number" readonly class="border-none text-center w-full"
                                        value="{{ $alternativeValues->where('criteria_id', $criteria->id)->sum('value') }}">
                                </td>
                            @endforeach
                        </tr> --}}
                    </form>
                </tbody>
            </table>
        </div>
    @else
        <div>
            <h1 class="text-center font-semibold text-lg py-4">This project is empty! start with add your own criteria
                or
                alternative.
            </h1>
        </div>
    @endif

    @if (auth()->user() == $project->user)
        <x-button label="Save" form="valueForm" wire:click='save' spinner="save" color="positive" />
    @endif
    {{-- Modals --}}

    {{-- Criteria --}}
    <x-modal.card title="Edit Criteria" blur wire:model.defer="editCriteriaModal">
        <x-errors />

        <div class="grid grid-cols-1 gap-4">
            <x-input label="Name" name="name" wire:model="editedCriteria.name" placeholder="Criteria Name" />
            <x-inputs.number min="0" max="10" label="Weight (1-10)" wire:model='editedCriteria.weight'
                name="weight" placeholder="5" />

            <x-toggle lg wire:model.defer="editedCriteria.isBenefit" left-label='Cost' label='Benefit' />
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                @if (!empty($editedCriteria))
                    <x-button flat negative label="Delete" wire:click="deleteCriteria({{ $editedCriteria['id'] }})" />
                    <div class="flex">
                        <x-button flat label="Cancel" x-on:click="close" />
                        <x-button primary label="Save" wire:click="updateCriteria({{ $editedCriteria['id'] }})" />
                    </div>
                @endif
            </div>
        </x-slot>
    </x-modal.card>

    <x-modal.card title="Add Criteria" blur wire:model.defer="addCriteriaModal">
        <x-errors />
        <div class="grid grid-cols-1 gap-4">
            <x-input label="Name" name="name" wire:model="addedCriteria.name" placeholder="Criteria Name" />
            <x-inputs.number min="0" max="10" label="Weight (1-10)" wire:model='addedCriteria.weight'
                name="weight" placeholder="5" />

            <x-toggle lg wire:model.defer="addedCriteria.isBenefit" left-label='Cost' label='Benefit' />
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <div></div>

                <div class="flex">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Save" wire:click="addCriteria" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>

    {{-- Alternative --}}
    <x-modal.card title="Add Alternative" blur wire:model.defer="addAlternativeModal">
        <div class="grid grid-cols-1 gap-4">
            <x-input label="Name" name="name" wire:model="addedAlternative.name" placeholder="Alternative Name" />
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">

                <div class="flex">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Save" wire:click="addAlternative" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>

    <x-modal.card title="Edit Alternative" blur wire:model.defer="editAlternativeModal">
        <div class="grid grid-cols-1 gap-4">
            <x-input label="Name" name="name" wire:model="editedAlternative.name"
                placeholder="Alternative Name" />
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                @if (!empty($editedAlternative))
                    <x-button flat negative label="Delete"
                        wire:click="deleteAlternative({{ $editedAlternative['id'] }})" />
                @endif

                <div class="flex">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Save" wire:click="updateAlternative" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>

</div>
