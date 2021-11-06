<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Operacje cykliczne') }}
    </h2>
</x-slot>

<div class="sm:py-12">
    <div name='content' class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:shadow-md sm:rounded border border-gray-light min-h-screen">
            <div class="mx-auto p-4 lg:p-12 rounded-2xl overflow-x-auto">
                <table class="table-auto">
                    <tbody>
                        @if($cyclicOperations->isNotEmpty())
                        <tr>
                            <td class="border px-4 py-2">
                                Nazwa
                            </td>
                            <td class="border px-4 py-2">
                                Wartość
                            </td>
                            <td class="border px-4 py-2">
                                Data kolejnego dodania operacji cyklicznej
                            </td>
                            <td class="border px-4 py-2">
                                Dodana przez
                            </td>
                            <td class="border px-4 py-2">
                                Akcja
                            </td>
                        </tr>
                        @endif
                        @forelse ($cyclicOperations as $operation)
                        <tr>
                            <td class="border px-4 py-2">{{ $operation->name }}</td>
                            <td class="border px-4 py-2">
                                <span
                                    class="{{$operation->income ? 'text-green-600' : 'text-red-600'}}">{{ $operation->value }}</span>
                            </td>
                            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($operation->cyclic_date)->format('d.m.Y') }}</td>
                            <td class="border px-4 py-2">{{ $operation->user->name }}</td>
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
