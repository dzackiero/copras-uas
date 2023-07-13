<div class="flex justify-between">
    <h3 class="font-semibold text-4xl mb-8 underline">{{ $title }}</h3>
    <div>
        <x-button md icon="plus" primary wire:click="$toggle('newProjectModal')" label="Add Project" />
    </div>

    <x-modal.card title="New Project" blur wire:model.defer="newProjectModal">
        <x-errors />
        <div class="grid grid-cols-1 gap-4">
            <x-input label="Name" name="name" wire:model="newProject.name" placeholder="Project Name" />

            <x-toggle lg wire:model.defer="newProject.isPrivate" label='Private' />
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <div></div>

                <div class="flex">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Save" wire:click="addProject" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
