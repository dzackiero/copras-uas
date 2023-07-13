<x-app-layout>
    <x-slot name="header">
        <livewire:edit-project :project="$project" />
    </x-slot>

    <x-notifications />

    <div class="py-12">
        <div class="max-w-7xl mx-3 sm:mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <livewire:project-table :project="$project" />
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <livewire:copras-detail :project="$project" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
