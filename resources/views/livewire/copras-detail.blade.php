<div>
    @if (
        $criteriaTotals->isNotEmpty() &&
            $criteriaTotals->where('total', 0)->isEmpty() &&
            $criterias->isNotEmpty() &&
            $criterias->where('isBenefit', false)->isNotEmpty() &&
            $alternatives->isNotEmpty())
        {{-- Criteria --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="font-semibold text-3xl mb-4">Bobot Criteria</h3>
                <table class="text-center">
                    <tr>
                        <th class="border px-2 py-4">Criteria</th>
                        <th class="border px-2 py-4">Weight</th>
                    </tr>
                    @foreach ($criterias as $criteria)
                        <tr>
                            <td class="border px-2 py-4">{{ $criteria->name }}</td>
                            <td class="border px-2 py-4">{{ round($criteria->weight / $criterias->sum('weight'), 3) }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        {{-- Matriks Ternormalisasi --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="font-semibold text-3xl mb-4">Matrix Ternormalisasi</h3>
                <table class="text-center">
                    <tr>
                        <th class="border px-2 py-4">Alternative</th>
                        @foreach ($criterias as $criteria)
                            <th class="border px-2 py-4">{{ $criteria->name }}</th>
                        @endforeach
                    </tr>
                    @foreach ($alternatives as $alternative)
                        <tr>
                            <td class="border px-2 py-4">{{ $alternative->name }}</td>
                            @foreach ($criterias as $criteria)
                                @php
                                    $xij_cell = $criteria->alternative_values->where('alternative_id', $alternative->id)->first()->value;
                                    $xij_sum = $criteria->alternative_values->sum('value');
                                @endphp
                                <td class="border px-2 py-4">
                                    {{-- Xij / ΣXij --}}
                                    {{ round($xij_cell / $xij_sum, 5) }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        {{-- Matriks Terbobot --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="font-semibold text-3xl mb-4">Matrix Terbobot</h3>
                <table class="text-center">
                    <tr>
                        <th class="border px-2 py-4">Alternative</th>
                        @foreach ($criterias as $criteria)
                            <th class="border px-2 py-4">{{ $criteria->name }}</th>
                        @endforeach
                    </tr>
                    @foreach ($alternatives as $alternative)
                        <tr>
                            <td class="border px-2 py-4">{{ $alternative->name }}</td>
                            @foreach ($criterias as $criteria)
                                @php
                                    $xij_cell = $criteria->alternative_values->where('alternative_id', $alternative->id)->first()->value;
                                    $xij_sum = $criteria->alternative_values->sum('value');
                                    $wij = $criteria->weight / $criterias->sum('weight');
                                @endphp
                                <td class="border px-2 py-4">
                                    {{-- (Xij / ΣXij) * Wj --}}
                                    {{ round(($xij_cell / $xij_sum) * $wij, 8) }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        {{-- Nilai Benefit & Cost --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="font-semibold text-3xl mb-4">Nilai Benefit & Cost</h3>
                <table class="text-center">
                    <tr>
                        <th class="border px-2 py-4">Alternative</th>
                        <th class="border px-2 py-4">Benefit</th>
                        <th class="border px-2 py-4">Cost</th>
                    </tr>
                    @foreach ($alternatives as $alternative)
                        <tr>
                            @php
                                $benefit_sum = 0;
                                $cost_sum = 0;
                            @endphp
                            <td class="border px-2 py-4">{{ $alternative->name }}</td>
                            @foreach ($criterias as $criteria)
                                @php
                                    $xij_cell = $criteria->alternative_values->where('alternative_id', $alternative->id)->first()->value;
                                    $xij_sum = $criteria->alternative_values->sum('value');
                                    $wij = $criteria->weight / $criterias->sum('weight');
                                    
                                    if ($criteria->isBenefit) {
                                        $benefit_sum += ($xij_cell / $xij_sum) * $wij;
                                    } else {
                                        $cost_sum += ($xij_cell / $xij_sum) * $wij;
                                    }
                                    
                                @endphp
                            @endforeach
                            <td class="border px-2 py-4">
                                {{ round($benefit_sum, 8) }}
                            </td>
                            <td class="border px-2 py-4">
                                {{ round($cost_sum, 8) }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        {{-- S-1 --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="font-semibold text-3xl mb-4">S - 1</h3>
                <table class="text-center">
                    <tr>
                        <th class="border px-2 py-4">Alternative</th>
                        <th class="border px-2 py-4">1/S-i</th>
                    </tr>
                    @php
                        $si_sum = 0;
                        $result = collect();
                    @endphp
                    @foreach ($alternatives as $alternative)
                        <tr>
                            @php
                                $benefit_sum = 0;
                                $cost_sum = 0;
                            @endphp
                            <td class="border px-2 py-4">{{ $alternative->name }}</td>
                            @foreach ($criterias as $criteria)
                                @php
                                    $xij_cell = $criteria->alternative_values->where('alternative_id', $alternative->id)->first()->value;
                                    $xij_sum = $criteria->alternative_values->sum('value');
                                    $wij = $criteria->weight / $criterias->sum('weight');
                                    
                                    if ($criteria->isBenefit) {
                                        $benefit_sum += ($xij_cell / $xij_sum) * $wij;
                                    } else {
                                        $cost_sum += ($xij_cell / $xij_sum) * $wij;
                                    }
                                @endphp
                            @endforeach
                            <td class="border px-2 py-4">
                                {{ round(1 / $cost_sum, 8) }}
                            </td>
                        </tr>
                        @php
                            $si_sum += 1 / $cost_sum;
                        @endphp
                    @endforeach
                    <tr class="font-semibold">
                        <td class="border px-2 py-2">Total</td>
                        <td class="border px-2 py-2">{{ $si_sum }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- S-i*(sum=1/s-i) --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="font-semibold text-3xl mb-4">S-i*(sum=1/s-i)</h3>
                <table class="text-center">
                    <tr>
                        <th class="border px-2 py-4">Alternative</th>
                        <th class="border px-2 py-4">S-i*(sum=1/s-i)</th>
                    </tr>
                    @foreach ($alternatives as $alternative)
                        <tr>
                            @php
                                $benefit_sum = 0;
                                $cost_sum = 0;
                            @endphp
                            <td class="border px-2 py-4">{{ $alternative->name }}</td>
                            @foreach ($criterias as $criteria)
                                @php
                                    $xij_cell = $criteria->alternative_values->where('alternative_id', $alternative->id)->first()->value;
                                    $xij_sum = $criteria->alternative_values->sum('value');
                                    $wij = $criteria->weight / $criterias->sum('weight');
                                    
                                    if ($criteria->isBenefit) {
                                        $benefit_sum += ($xij_cell / $xij_sum) * $wij;
                                    } else {
                                        $cost_sum += ($xij_cell / $xij_sum) * $wij;
                                    }
                                @endphp
                            @endforeach
                            <td class="border px-2 py-4">
                                {{ round($cost_sum * $si_sum, 8) }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        {{-- Result --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="font-semibold text-3xl mb-4">Result</h3>
                <table class="text-center">
                    <tr>
                        <th class="border px-2 py-4">Alternative</th>
                        <th class="border px-2 py-4">S-i*(sum=1/s-i)</th>
                    </tr>
                    @foreach ($alternatives as $alternative)
                        <tr>
                            @php
                                $benefit_sum = 0;
                                $cost_sum = 0;
                                
                            @endphp
                            <td class="border px-2 py-4">{{ $alternative->name }}</td>
                            @foreach ($criterias as $criteria)
                                @php
                                    $xij_cell = $criteria->alternative_values->where('alternative_id', $alternative->id)->first()->value;
                                    $xij_sum = $criteria->alternative_values->sum('value');
                                    $wij = $criteria->weight / $criterias->sum('weight');
                                    
                                    if ($criteria->isBenefit) {
                                        $benefit_sum += ($xij_cell / $xij_sum) * $wij;
                                    } else {
                                        $cost_sum += ($xij_cell / $xij_sum) * $wij;
                                    }
                                @endphp
                            @endforeach
                            <td class="border px-2 py-4">
                                @php
                                    $res = [
                                        'alternative' => $alternative,
                                        'result' => $benefit_sum + $criterias->where('isBenefit', false)->sum('weight') / $criterias->sum('weight') / ($cost_sum * $si_sum),
                                    ];
                                    $result->push($res);
                                @endphp
                                {{ round(
                                    $benefit_sum +
                                        $criterias->where('isBenefit', false)->sum('weight') / $criterias->sum('weight') / ($cost_sum * $si_sum),
                                    8,
                                ) }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        {{-- Ranking --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="font-semibold text-3xl mb-4">Ranking</h3>
                <table class="text-center">
                    <tr>
                        <th class="border px-2 py-4">Alternative</th>
                        <th class="border px-2 py-4">Value</th>
                        <th class="border px-2 py-4">Ranking</th>
                    </tr>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($result->sortByDesc('result') as $res)
                        <tr>
                            <td class="border px-2 py-4">{{ $res['alternative']->name }}</td>
                            <td class="border px-2 py-4">{{ $res['result'] }}</td>
                            <td class="border px-2 py-4">{{ $i }}</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </table>
            </div>
        </div>
    @else
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                There is something wrong with the data. Please update this data.
            </div>
        </div>
    @endif
</div>
