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
                <x-jet-secondary-button wire:click="$toggle('deleting')" wire:loading.attr="disabled">
                    {{ __('Nie') }}
                </x-jet-secondary-button>

                <x-jet-button wire:click="destroy({{ $selected_id }})" wire:loading.attr="disabled">
                    {{ __('Tak') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
