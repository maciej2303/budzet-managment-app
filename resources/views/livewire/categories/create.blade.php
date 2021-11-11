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
                <x-jet-label for="name" value="{{ __('Nazwa') }}" />
                    <x-jet-input type="name" class="mt-1 block w-3/4 {{$errors->has('name') ? 'border-red-500' : ''}}"
                                x-ref="name"
                                wire:model.defer="name"
                                wire:keydown.enter="save" />

                    <x-jet-input-error for="name" class="mt-2" />
                </div>

                <div class="mt-4 w-full">
                <select name="income" type="income"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-1 block w-3/4"
                            x-ref="income" wire:model="income">
                            <option value="0">Wydatek</option>
                            <option value="1">Przychód</option>
                        </select>
                </div>

                <div class="mt-4" >
                <x-jet-label for="icon" value="{{ __('Ikona') }}" />
                    <x-jet-input type="file" class="mt-1 block w-3/4 {{$errors->has('icon') ? 'border-red-500' : ''}}" wire:model.defer="icon"
                        wire:keydown.enter="save" />

                    <x-jet-input-error for="icon" class="mt-2" />
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
