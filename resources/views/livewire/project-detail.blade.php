<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="space-y-4">

                    <x-button bg info icon="plus" label="Add Altenative" wire:click="$toggle('addAlternativeModal')" />
                    {{-- <x-button bg info label="Add Altenative" wire:click="moora" /> --}}

                    <div class="relative overflow-x-auto rounded-md">
                        <table class="w-full  text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="border text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 border">
                                        Alternative
                                    </th>
                                    @foreach ($criterias as $criteria)
                                        <th scope="col" class="pl-6 pr-4 py-2 border">
                                            <div class="flex justify-between items-center">
                                                <p>{{ $criteria->name }}</p>
                                                <x-button.circle wire:click="editCriteria({{ $criteria->id }})"
                                                    icon="pencil" />
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($alternatives as $alternative)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="border-l pl-6 pr-4 py-2 flex items-center justify-between font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $alternative->name }}
                                            <x-button.circle wire:click="editAlternative({{ $alternative->id }})"
                                                icon="pencil" />
                                        </th>
                                        @foreach ($alternativeValues->where('alternative_id', $alternative->id) as $alternativeValue)
                                            <td class="border px-6 py-4 text-center">
                                                {{ $alternativeValue->value }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <th scope="row" colspan="5"
                                            class="border text-center text-base px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Your alternative is empty! Add Alternative to start your Moora
                                        </th>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <x-modal.card title="Add Alternative" blur wire:model.defer="addAlternativeModal">
                        <div class="grid grid-cols-1 gap-4">
                            <x-input wire:model="modalAlternative.name" label="Alternative Name"
                                placeholder="Hero Name" />
                            <x-inputs.number wire:model="modalAlternative.1" label="Durability (Benefit)" />
                            <x-inputs.number wire:model="modalAlternative.2" label="Damage (Benefit)" />
                            <x-inputs.number wire:model="modalAlternative.3" label="Crowd Control (Benefit)" />
                            <x-inputs.number wire:model="modalAlternative.4" label="Difficulty (Cost)" />
                        </div>

                        <x-slot name="footer">
                            <div class="flex justify-end gap-x-4">
                                <div class="flex">
                                    <x-button flat label="Cancel" x-on:click="close" />
                                    <x-button primary label="Save" wire:click="addAlternative" />
                                </div>
                            </div>
                        </x-slot>
                    </x-modal.card>

                    <x-modal.card title="Edit Alternative" blur wire:model.defer="editAlternativeModal">
                        <div class="grid grid-cols-1 gap-4">
                            <x-input wire:model="modalAlternative.name" label="Alternative Name"
                                placeholder="Hero Name" />
                            <x-inputs.number wire:model="modalAlternative.1" label="Durability (Benefit)" />
                            <x-inputs.number wire:model="modalAlternative.2" label="Damage (Benefit)" />
                            <x-inputs.number wire:model="modalAlternative.3" label="Crowd Control (Benefit)" />
                            <x-inputs.number wire:model="modalAlternative.4" label="Difficulty (Cost)" />
                        </div>
                        @if ($editAlternativeModal)
                            <x-slot name="footer">
                                <div class="flex justify-between gap-x-4">
                                    <x-button flat negative label="Delete" wire:click="deleteAlternative" />

                                    <div class="flex">
                                        <x-button flat label="Cancel" x-on:click="close" />
                                        <x-button primary label="Save" wire:click="updateAlternative()" />
                                    </div>
                                </div>
                            </x-slot>
                        @endif
                    </x-modal.card>

                    <x-modal.card title="Edit Criteria" blur wire:model.defer="editCriteriaModal">
                        <div class="grid grid-cols-1 gap-4">
                            <x-input wire:model="modalCriteria.name" readonly label="Criteria Name" />
                            <x-inputs.number min="1" max="10" wire:model="modalCriteria.weight"
                                label="Weight" />
                        </div>
                        @if ($editCriteriaModal)
                            <x-slot name="footer">
                                <div class="flex justify-between gap-x-4">
                                    <x-button flat negative label="Delete" wire:click="deleteCriteria" />

                                    <div class="flex">
                                        <x-button flat label="Cancel" x-on:click="close" />
                                        <x-button primary label="Save" wire:click="updateCriteria" />
                                    </div>
                                </div>
                            </x-slot>
                        @endif
                    </x-modal.card>

                </div>

            </div>
        </div>
    </div>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="space">
                        <table class="w-full  text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="border text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 border">
                                        Alternative
                                    </th>
                                    <th scope="col" class="px-6 py-3 border">
                                        Optimized Value
                                    </th>
                                    <th scope="col" class="px-6 py-3 border">
                                        Ranking
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp

                                @forelse ($ranking as $rank)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="border-l pl-6 pr-4 py-4 flex items-center justify-between font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $rank['alternative'] }}
                                        </th>
                                        <td class="border px-6 py-4 text-center">
                                            {{ $rank['value'] }}
                                        </td>
                                        <td class="border px-6 py-4 text-center">
                                            {{ $i }}
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @empty
                                    <tr>
                                        <th scope="row" colspan="5"
                                            class="border text-center text-base px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Your alternative is empty! Add Alternative to start your Moora
                                        </th>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
