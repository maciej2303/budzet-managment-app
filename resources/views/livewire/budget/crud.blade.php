<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Budżet') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <x-jet-button wire:click="expense" wire:loading.attr="disabled">
            {{ __('Dodaj wydatek') }}
        </x-jet-button>
        <x-jet-button wire:click="profit" wire:loading.attr="disabled">
            {{ __('Dodaj przychód') }}
        </x-jet-button>
        <p>Saldo konta {{$budget->balance}}</p>
        <table class="table-auto">
            <thead>
              <tr>
                <th class="px-4 py-2">Operacja</th>
                <th class="px-4 py-2">Wartość</th>
                <th class="px-4 py-2">Kategoria</th>
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
                        <td class="border px-4 py-2">
                            <x-jet-button wire:click="editing({{ $operation->id }})" wire:loading.attr="disabled">
                                {{ __('Edytuj') }}
                            </x-jet-button>
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
    @include('livewire.budget.edit')
</div>
