<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Operacje cykliczne') }}
    </h2>
</x-slot>

<div class="sm:py-12">
    <div name='content' class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:shadow-md sm:rounded border border-gray-light min-h-screen">
            <div class="mx-auto p-4 lg:p-12 rounded-2xl overflow-x-auto">
                <section class="container mx-auto pt-4">
                    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full">
                                <thead class="text-center">
                                    @if($cyclicOperations->isNotEmpty())
                                    <tr
                                        class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-300 uppercase border-b border-gray-600 text-center">
                                        <th class="px-4 py-2">Nazwa</th>
                                        <th class="px-4 py-2">Rodzaj</th>
                                        <th class="px-4 py-2">Data</th>
                                        <th class="px-4 py-2">Dodana przez</th>
                                        <th class="px-4 py-2">Działania</th>
                                    </tr>
                                    @endif
                                </thead>
                                <tbody class="text-center">
                                    @forelse ($cyclicOperations as $operation)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $operation->name }}</td>
                                        <td class="border px-4 py-2">
                                            <span
                                                class="{{$operation->income ? 'text-green-600' : 'text-red-600'}}">{{ $operation->value }}</span>
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ \Carbon\Carbon::parse($operation->cyclic_date)->format('d.m.Y') }}</td>
                                        <td class="border px-4 py-2">{{ $operation->user->name }}</td>
                                        <td class="border px-4 py-2">
                                            @if(auth()->user()->ownedBudget != null)
                                            <x-jet-danger-button wire:click="deleting({{ $operation->id }})"
                                                wire:loading.attr="disabled">
                                                {{ __('Usuń') }}
                                            </x-jet-danger-button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <h3 class="text-lg leading-6 font-medium text-red-500">Brak operacji cyklicznych
                                    </h3>
                                    <br>
                                    <span class="text-base pt-4">Aby dodać operację cykliczną należy przy dodawaniu
                                        nowej operacji zaznaczyć opcję "Cykliczna"</span>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @include('livewire.cyclic-operations.delete')
</div>
