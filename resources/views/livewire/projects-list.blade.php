<div>
    @if ($searchable)
        <div class="flex flex-col sm:flex-row gap-3 mb-4">
            <x-input icon="search" wire:model='search' class="sm:w-96" placeholder="search for projects..." />
            <x-native-select class="text-gray-500" :options="[
                ['display' => 'Recently created', 'value' => 'created_at'],
                ['display' => 'Recently updated', 'value' => 'updated_at'],
            ]" option-label="display" option-value="value"
                wire:model="sortBy" />
        </div>
    @endif
    <div class="grid grid-cols-2 gap-4">
        @foreach ($projects as $project)
            <a href="{{ route('project-detail', $project->id) }}">
                <div
                    class="flex justify-between bg-white px-4 py-3 h-32 rounded-md  duration-100 hover:scale-[1.01] hover:cursor-pointer border border-gray-300 shadow">
                    <div class="flex flex-col justify-between">
                        <div>
                            <p class="font-semibold text-2xl">{{ $project->name }}</p>
                            <p>{{ $project->user->username }}</p>
                        </div>
                        <div>
                            <p class="text-sm">{{ date('d/m/Y', strtotime($project->created_at)) }}</p>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
        <div class="col-span-2">
            {{ $projects->links() }}
        </div>
    </div>

</div>
