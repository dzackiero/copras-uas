<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Project : {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <p class="font-semibold text-xl mb-6"></p>
                    @php
                        $criteriaCount = $criterias->count();
                    @endphp
                    {{-- <div class="grid grid-cols-{{ $criteriaCount + 1 }} grid-cols-5"> --}}
                    <table>

                        <tr>
                            <th class="font-semibold">Alternative</th>
                            @foreach ($criterias as $criteria)
                                <th class="font-semibold">{{ $criteria->name }}</th>
                            @endforeach
                        </tr>

                        @foreach ($alternatives as $alternative)
                            <tr>
                                <td>{{ $alternative->name }}</td>
                                @foreach ($criterias as $criteria)
                                    <td>
                                        <input type="number" name="" id=""
                                            value="{{ $values->where('criteria_id', $criteria->id)->where('alternative_id', $alternative->id)->first()->value ?? 0 }}">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                    {{-- </div> --}}
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    COPRAS
                </div>
            </div>
</x-app-layout>
