<div class="space-y-4">
    <x-button wire:click="addCriteria" label='Criteria' />
    <x-button wire:click="addAlternative" label='Alt' />
    <div
        class="overflow-x-auto pb-2 scrollbar-thin scrollbar-track-neutral-100 scrollbar-track-rounded scrollbar-thumb-neutral-300 scrollbar-thumb-rounded ">
        <table class="w-full text-center ">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Alternative</th>
                    @foreach ($criterias as $criteria)
                        <th class="border px-4 py-2">
                            <div>{{ $criteria->name }}
                                {{ $criteria->isBenefit ? '(Benefit)' : '(Cost)' }}
                            </div>
                            <x-button wire:click="deleteCriteria({{ $criteria->id }})" icon="trash" />
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach ($alternatives as $alternative)
                    <tr>
                        <td>
                            <p>
                                {{ $alternative->name }}
                                <x-button wire:click="deleteAlternative({{ $alternative->id }})" icon="trash" />

                            </p>
                        </td>
                        @foreach ($criterias as $criteria)
                            <td>
                                <input type="number" class="border-none text-center" min="0"
                                    value="{{ $values->where('criteria_id', $criteria->id)->where('alternative_id', $alternative->id)->first()->value ?? 0 }}">
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
