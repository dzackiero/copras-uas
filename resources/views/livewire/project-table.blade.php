<div class="space-y-4">
    <x-button wire:click="addCriteria" label='Add Criteria' icon="plus" color="primary" />
    <x-button wire:click="addAlternative" label='Add Alternative' color="primary" icon="plus" />
    <div class="overflow-x-auto pb-2 soft-scrollbar">
        <table class="w-full text-center ">
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
                                    <x-button wire:click="editAlternative({{ $criteria->id }})" icon="pencil" />
                                </p>
                            </td>
                            @foreach ($criterias as $criteria)
                                <td class="border">
                                    <input type="number" placeholder="0"
                                        wire:key='{{ 'crit-' . $criteria->id . '-alt-' . $alternative->id }}'
                                        wire:model='value.{{ 'crit-' . $criteria->id . '-alt-' . $alternative->id }}'
                                        name="{{ 'crit-' . $criteria->id . '-alt-' . $alternative->id }}"
                                        class="border-none text-center w-full" min="0">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </form>
            </tbody>
        </table>
    </div>

    <x-button label="Save" form="valueForm" wire:click='save' spinner="save" color="positive" />

    {{-- Modals --}}

    {{-- Criteria --}}
    <x-modal.card title="Edit Criteria" blur wire:model.defer="editCriteriaModal">
        <div class="grid grid-cols-1 gap-4">
            <x-input label="Name" name="name" wire:model="editedCriteria.name" placeholder="Criteria Name" />
            <x-input label="Weight (1-10)" wire:model='editedCriteria.weight' name="weight" placeholder="1 - 10" />

            <x-toggle lg wire:model.defer="editedCriteria.isBenefit" left-label='Cost' label='Benefit' />
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                @isset($editedCriteria)
                    <x-button flat negative label="Delete" wire:click="deleteCriteria({{ $editedCriteria['id'] }})" />
                @endisset

                <div class="flex">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Save" wire:click="updateCriteria" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>

    {{-- Alternative --}}
    <x-modal.card title="Edit " blur wire:model.defer="editAlternativeModal">
        <div class="grid grid-cols-1 gap-4">
            <x-input label="Name" name="name" wire:model="editedAlternative.name" placeholder="Alternative Name" />
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                @isset($editedAlternative)
                    <x-button flat negative label="Delete" wire:click="deleteAlternative({{ $editedAlternative['id'] }})" />
                @endisset

                <div class="flex">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Save" wire:click="updateAlternative" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
