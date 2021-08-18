<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Budżet') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        @if($budget->isThresholdExceeded())
        <div class="transition duration-500 bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-2 rounded relative"
            role="alert" id="thresholdAlert">
            <strong class="font-bold">Uwaga!</strong>
            <span class="block sm:inline">Przekroczyłeś swój miesięczny próg wydatków.</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" onclick="hideAlert()">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
        @endif

        <x-jet-button wire:click="expense" wire:loading.attr="disabled">
            {{ __('Dodaj wydatek') }}
        </x-jet-button>
        <x-jet-button wire:click="profit" wire:loading.attr="disabled">
            {{ __('Dodaj przychód') }}
        </x-jet-button>
        <p class="mt-2">Saldo konta: {{ number_format($budget->balance, 2) }}</p>
        <p class="mt-2">Próg wydatkow: {{ number_format($budget->threshold, 2) }}</p>
        <x-jet-button wire:click="thresholdModal" wire:loading.attr="disabled">
            {{ __('Ustaw próg wydatków') }}
        </x-jet-button>
        <table class="table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Operacja</th>
                    <th class="px-4 py-2">Wartość</th>
                    <th class="px-4 py-2">Kategoria</th>
                    <th class="px-4 py-2">Opis</th>
                    <th class="px-4 py-2">Dokument</th>
                    <th class="px-4 py-2">Opcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($budget->operations as $operation)
                <tr>
                    <td class="border px-4 py-2">
                        @if ($operation->income)
                        <span class="text-green-600">Przychód</span>
                        @else
                        <span class="text-red-600">Wydatek</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ $operation->value }}</td>
                    <td class="border px-4 py-2">{{ $operation->category->name }}</td>
                    <td class="border px-4 py-2">{{ $operation->description }}</td>
                    <td class="border px-4 py-2">
                        @isset($operation->image)
                        @if (@is_array(getimagesize($operation->image)))
                        <img class="object-scale-down" style="max-width: 300px" src="{{ asset($operation->image) }}">
                        @else
                        <a href="{{asset($operation->image)}}" class="flex justify-center">
                            Pobierz plik <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </a>
                        @endif
                        @endisset
                    </td>
                    <td class="border px-4 py-2">
                        {{-- <x-jet-button wire:click="editing({{ $operation->id }})" wire:loading.attr="disabled">
                        {{ __('Edytuj') }}
                        </x-jet-button> --}}
                        <x-jet-danger-button wire:click="deleting({{ $operation->id }})" wire:loading.attr="disabled">
                            {{ __('Usuń') }}
                        </x-jet-danger-button>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('livewire.budget.create')
    @include('livewire.budget.delete')
    {{-- @include('livewire.budget.edit') --}}
    @include('livewire.budget.threshold')
</div>
@push('js')
<script>
    function hideAlert() {
        const target = document.getElementById("thresholdAlert");
        target.addEventListener('click', () => target.style.opacity = '0');
        target.addEventListener('transitionend', () => target.remove());
    }

</script>
@endpush
