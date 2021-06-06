<div>
    <div name="content">
        <!-- Delete User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="deleting">
            <x-slot name="title">
                {{ __('Usuń jednostkę') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Na pewno?') }}
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-white px-4 py-2" wire:click="$toggle('deleting')" wire:loading.attr="disabled">
                    {{ __('Nie') }}
                </button>

                <button class="btn btn-green px-4 py-2 ml-2" wire:click="destroy({{ $selected_id }})" wire:loading.attr="disabled">
                    {{ __('Tak') }}
                </button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
