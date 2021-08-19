<div>
    <div name="content">
        <div class="mt-5">
        </div>

        <!--Confirmation Modal -->
        <x-jet-dialog-modal wire:model="creating">
            <x-slot name="title">
                {{ __('Dodawanie nowej kategorii') }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                <x-jet-label for="invitationLink" value="{{ __('Nazwa') }}" />
                    <x-jet-input type="invitationLink" class="mt-1 block w-3/4" readonly
                                x-ref="invitationLink"
                                wire:model.defer="invitationLink"
                                wire:keydown.enter="save" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('creating')" wire:loading.attr="disabled">
                    {{ __('Anuluj') }}
                </x-jet-secondary-button>

                <x-jet-button wire:click="save" wire:loading.attr="disabled">
                    {{ __('Zapisz') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
