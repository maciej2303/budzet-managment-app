<div>
    <div name="content">
        <!--Confirmation Modal -->
        <x-jet-dialog-modal wire:model="editing">
           <x-slot name="title">
                Edycja
                @if ($income)
                    przychodu.
                @else
                    wydatku.
                @endif
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                <x-jet-label for="value" value="{{ __('Kwota') }}" />
                    <x-jet-input type="value" class="mt-1 block w-3/4"
                                x-ref="value"
                                wire:model.defer="value"
                                wire:keydown.enter="save" />

                    <x-jet-input-error for="value" class="mt-2" />
                </div>

                <div class="mt-4" >
                <x-jet-label for="image" value="{{ __('Opis') }}" />
                    <x-jet-input type="description" class="mt-1 block w-3/4"
                                x-ref="description"
                                wire:model.defer="description"
                                wire:keydown.enter="save" />

                    <x-jet-input-error for="description" class="mt-2" />
                </div>

                <div class="mt-4" >
                <x-jet-label for="category_id" value="{{ __('Kategoria') }}" />
                    <select name="" type="category_id" class="mt-1 block w-3/4"
                        x-ref="category_id"
                        wire:model="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <x-jet-input-error for="description" class="mt-2" />
                </div>

                <div class="mt-4" >
                <x-jet-label for="image" value="{{ __('Zdjęcie (Opcjonalne)') }}" />
                    <x-jet-input type="file" class="mt-1 block w-3/4" wire:model.defer="image"
                        wire:keydown.enter="save" />

                    <x-jet-input-error for="image" class="mt-2" />
                </div>

            </x-slot>
            <x-slot name="footer">
                <button class="btn btn-white px-4 py-2" wire:click="$toggle('editing')" wire:loading.attr="disabled">
                    {{ __('Anuluj') }}
                </button>

                <button class="btn btn-green px-4 py-2 ml-2" wire:click="save" wire:loading.attr="disabled">
                    {{ __('Zapisz') }}
                </button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
