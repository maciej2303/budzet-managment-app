<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Operacje cykliczne') }}
    </h2>
</x-slot>

<div class="sm:py-12">
    <div name='content' class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:shadow-md sm:rounded border border-gray-light">
            <div class="mx-auto p-4 lg:p-12 rounded-2xl">
                <table class="table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Operacja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($budget->cyclicOperations as $operation)
                        <tr>
                            <td class="border px-4 py-2">{{ $operation->created_at->format('d.m.Y') }}</td>
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
                                <img class="object-scale-down" style="max-width: 300px"
                                    src="{{ asset($operation->image) }}">
                                @else
                                <a href="{{asset($operation->image)}}" class="flex justify-center">
                                    Pobierz plik <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                                @endif
                                @endisset
                            </td>
                            <td class="border px-4 py-2">
                                <x-jet-danger-button wire:click="deleting({{ $operation->id }})"
                                    wire:loading.attr="disabled">
                                    {{ __('Usuń') }}
                                </x-jet-danger-button>
                        </tr>
                        @empty
                            <span>Brak operacji cyklicznych</span>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('livewire.cyclic-operations.delete')
</div>
