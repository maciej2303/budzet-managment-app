<div>
    <div name="content">
        <div class="mt-5">
        </div>

        <!--Confirmation Modal -->
        <x-jet-dialog-modal wire:model="thresholdModal">
            <x-slot name="title">
                Ustaw miesięczny próg wydatków
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                <x-jet-label for="threshold" value="{{ __('Miesięczny próg wydatków') }}" />
                    <x-jet-input type="threshold" class="mt-1 block w-3/4"
                                x-ref="threshold"
                                wire:model.defer="threshold"
                                wire:keydown.enter="save" />

                    <x-jet-input-error for="threshold" class="mt-2" />
                </div>

            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button class="btn btn-white px-4 py-2" wire:click="$toggle('thresholdModal')" wire:loading.attr="disabled">
                    {{ __('Anuluj') }}
                </x-jet-secondary-button>

                <x-jet-button wire:click="setThreshold" wire:loading.attr="disabled">
                    {{ __('Zapisz') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
