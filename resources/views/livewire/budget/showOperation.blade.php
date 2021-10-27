<div>
    <div name="content">
        <div class="mt-5">
        </div>
        <!--Confirmation Modal -->
        <x-jet-dialog-modal wire:model="showOperation">
            <x-slot name="title">
                Operacja
            </x-slot>
            <x-slot name="content">
                <div class="mt-4">
                    @if($operationOnModal != null)
                    <p>Nazwa operacji: {{$operationOnModal->name ?? ''}}</p>
                    <p>
                        {{$operationOnModal->value > 0 ? "PRZYCHÓD" : "WYDATEK"}}
                        <span class="font-bold text-base {{$operationOnModal->value > 0 ? 'text-green-600' : 'text-red-600'}}">
                            {{ $operationOnModal->value}} PLN</span>
                    </p>
                    <p>Dodano: {{$operationOnModal->created_at->format('d.m.Y') ?? ''}}</p>
                    <p>Dodano przez: {{$operationOnModal->user->name}}</p>
                    <p>Kategoria: {{$operationOnModal->category->name}}</p>
                    <p>Opis: {{$operationOnModal->description}}</p>
                    @isset($operationOnModal->image)
                    <p>Plik: </p>
                    @if (@is_array(getimagesize($operationOnModal->image)))
                    <img class="object-scale-down" style="max-width: 300px" src="{{ asset($operationOnModal->image) }}">
                    @else
                    <a href="{{asset($operationOnModal->image)}}" class="flex justify-center">
                        Pobierz plik <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </a>
                    @endif
                    @endisset
                    @endif
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('showOperation')" wire:loading.attr="disabled">
                    {{ __('Zamknij') }}
                </x-jet-secondary-button>
                @if($operationOnModal != null)
                <x-jet-danger-button wire:click="deleting({{ $operationOnModal->id }})"
                                    wire:loading.attr="disabled">
                                    {{ __('Usuń') }}
                                </x-jet-danger-button>
                @endif
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
