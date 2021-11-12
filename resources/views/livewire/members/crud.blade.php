<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Użytkownicy w budżecie') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:shadow-md sm:rounded border border-gray-light min-h-screen">
            <div class="mx-auto p-4 lg:p-12 rounded-2xl overflow-x-auto">
                <section class="container mx-auto pt-4">
                    <div class="relative flex justify-between items-center">
                        <span class="text-3xl py-4">Użytkownicy w budżecie</span>
                        <x-jet-button wire:click="creating" wire:loading.attr="disabled">
                            {{ __('Dodaj nowego użytkownika') }}
                        </x-jet-button>
                    </div>
                    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full">
                                <thead class="text-center">
                                    <tr
                                        class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-300 uppercase border-b border-gray-600 text-center">
                                        <th class="px-4 py-2">Imię i nazwisko</th>
                                        <th class="px-4 py-2">E-mail</th>
                                        <th class="px-4 py-2">Działania</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($data as $member)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $member->name }}</td>
                                        <td class="border px-4 py-2">{{ $member->email }}</td>
                                        <td class="border px-4 py-2">
                                            <div class="flex justify-center">
                                                <x-jet-danger-button wire:click="deleting({{ $member->id }})"
                                                    wire:loading.attr="disabled">
                                                    {{ __('Usuń') }}
                                                </x-jet-danger-button>
                                            </div>

                                        </td>
                                    </tr>
                                    @endforeach
                                    {{ $data->links() }}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @include('livewire.members.create')
    @include('livewire.members.delete')
</div>
