@if (
    $criteriaTotals->isNotEmpty() &&
        $criteriaTotals->where('total', 0)->isEmpty() &&
        $criterias->isNotEmpty() &&
        $alternatives->isNotEmpty())
    <h3 class="font-semibold text-xl">Bobot Criteria</h3>

    {{-- Criteria --}}
    <table class="text-center">
        <tr>
            <th class="border px-2 py-4">Criteria</th>
            <th class="border px-2 py-4">Weight</th>
        </tr>

        @foreach ($criterias as $criteria)
            <tr>
                <td class="border px-2 py-4">{{ $criteria->name }}</td>
                <td class="border px-2 py-4">{{ round($criteria->weight / $criteriaSum, 2) }}</td>
            </tr>
        @endforeach

    </table>

    {{-- Matriks Ternormalisasi --}}
    <h3 class="mt-4 font-semibold text-xl">Matrix Ternormalisasi</h3>
    <table class="text-center">
        @foreach ($alternatives as $alternative)
            <tr>
                <td class="border px-2 py-4">{{ $alternative->name }}</td>
                @foreach ($criterias as $criteria)
                    @php
                        $xij_cell = $alternativeValues
                            ->where('criteria_id', $criteria->id)
                            ->where('alternative_id', $alternative->id)
                            ->first()->value;
                        $xij_sum = $criteria->alternative_values->sum('value');
                    @endphp
                    <td class="border px-2 py-4">
                        {{-- Xij / ΣXij --}}
                        {{ round($xij_cell / ($xij_sum != 0 ? $xij_sum : 1), 5) }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>

    <h3 class="mt-4 font-semibold text-xl">Matrix Terbobot</h3>
    <table class="text-center">
        @foreach ($alternatives as $alternative)
            <tr>
                <td class="border px-2 py-4">{{ $alternative->name }}</td>
                @foreach ($criterias as $criteria)
                    @php
                        $xij_cell = $alternativeValues
                            ->where('criteria_id', $criteria->id)
                            ->where('alternative_id', $alternative->id)
                            ->first()->value;
                        $xij_sum = $criteria->alternative_values->sum('value');
                        $wij = $criteria->weight / $criteriaSum;
                    @endphp
                    <td class="border px-2 py-4">
                        {{-- (Xij / ΣXij) * Wj --}}
                        {{ round(($xij_cell / $xij_sum) * $wij, 5) }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>

    <h3 class="mt-4 font-semibold text-xl">Nilai Index Benefit & Cost</h3>
    <table class="text-center">
        @foreach ($alternatives as $alternative)
            <tr>
                <td class="border px-2 py-4">{{ $alternative->name }}</td>
                @foreach ($criterias as $criteria)
                    @php
                        $xij_cell = $alternativeValues
                            ->where('criteria_id', $criteria->id)
                            ->where('alternative_id', $alternative->id)
                            ->first()->value;
                        $xij_sum = $criteria->alternative_values->sum('value');
                        $wij = $criteria->weight / $criteriaSum;
                    @endphp
                    <td class="border px-2 py-4">
                        {{-- (Xij / ΣXij) * Wj --}}
                        {{ round(($xij_cell / $xij_sum) * $wij, 5) }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
    </div>
@else
    <div>
        There is something wrong with the data. Please update this data.
    </div>
@endif
