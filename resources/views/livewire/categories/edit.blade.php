<div>
    <div name="content">
        <!--Confirmation Modal -->
        <x-jet-dialog-modal wire:model="editing">
            <x-slot name="title">
                {{ __('Edycja kategorii') }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                 <x-jet-label for="name" value="{{ __('Nazwa') }}" />
                    <x-jet-input type="name" class="mt-1 block w-3/4"
                                x-ref="name"
                                wire:model.defer="name"
                                wire:keydown.enter="save" />

                    <x-jet-input-error for="name" class="mt-2" />
                </div>

                <div class="mt-4" >
                <x-jet-label for="icon" value="{{ __('Ikona') }}" />
                    <x-jet-input type="file" class="mt-1 block w-3/4" wire:model.defer="icon"
                        wire:keydown.enter="save" />

                    <x-jet-input-error for="icon" class="mt-2" />
                </div>

            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('editing')" wire:loading.attr="disabled">
                    {{ __('Anuluj') }}
                </x-jet-secondary-button>

                <x-jet-button wire:click="update" wire:loading.attr="disabled">
                    {{ __('Zapisz') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
