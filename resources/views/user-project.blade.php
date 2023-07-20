<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Your Project
        </h2>
    </x-slot>


    <livewire:project-detail :user="$user" />

</x-app-layout>
