<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Użytkownicy w budżecie') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <p class="text-3xl py-4">Użytkownicy w budżecie</p>
        <x-jet-button wire:click="creating" wire:loading.attr="disabled">
            {{ __('Dodaj nowego użytkownika') }}
        </x-jet-button>
        <table class="table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Imię i nazwisko</th>
                    <th class="px-4 py-2">E-mail</th>
                    <th class="px-4 py-2">Działania</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $member)
                <tr>
                    <td class="border px-4 py-2">{{ $member->name }}</td>
                    <td class="border px-4 py-2">{{ $member->email }}</td>
                    <td class="border px-4 py-2">
                        <x-jet-danger-button wire:click="deleting({{ $member->id }})" wire:loading.attr="disabled">
                            {{ __('Usuń') }}
                        </x-jet-danger-button>
                    </td>
                </tr>
                @endforeach
                {{ $data->links() }}
            </tbody>
        </table>
    </div>
    @include('livewire.categories.create')
    @include('livewire.categories.delete')
</div>
