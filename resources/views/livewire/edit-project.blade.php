<div>
    <div class="flex w-full justify-between">
        <div class="flex gap-3 items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a class="hover:underline"
                    href="{{ route('user-projects', $project->user->username) }}">{{ $project->user->username }}</a>
                | {{ $project->name }}
            </h2>
            @if (auth()->user()->id == $project->user->id)
                <x-button icon="pencil" primary wire:click="editProject" />
            @endif
        </div>
        <x-badge lg label="{{ $project->isPrivate ? 'Private' : 'Public' }}" />
    </div>

    <x-modal.card title="Edit Project" blur wire:model.defer="editProjectModal">
        <div class="grid grid-cols-1 gap-4">
            <x-input label="Name" name="name" wire:model="editedProject.name" placeholder="Project Name" />

            <x-toggle lg wire:model.defer="editedProject.isPrivate" label='Private' />
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <div></div>
                <div class="flex">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Save" wire:click="updateProject" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
