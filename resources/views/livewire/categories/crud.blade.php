<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Kategorie') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <p class="text-3xl py-4">Kategorie dodane do budżetu</p>
        <x-jet-button wire:click="creating" wire:loading.attr="disabled">
            {{ __('Nowa kategoria') }}
        </x-jet-button>
        <table class="table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Nazwa</th>
                    <th class="px-4 py-2">Ikona</th>
                    <th class="px-4 py-2">Działania</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $category)
                <tr>
                    <td class="border px-4 py-2">{{ $category->name }}</td>
                    <td class="border px-4 py-2">
                        <img src="{{asset($category->icon)}}" style="max-height: 100px">
                    </td>
                    <td class="border px-4 py-2">
                        <x-jet-button wire:click="editing({{ $category->id }})" wire:loading.attr="disabled">
                            {{ __('Edytuj') }}
                        </x-jet-button>
                        <x-jet-danger-button wire:click="deleting({{ $category->id }})" wire:loading.attr="disabled">
                            {{ __('Usuń') }}
                        </x-jet-danger-button>
                    </td>
                </tr>
                @endforeach
                {{ $data->links() }}
            </tbody>
        </table>
        <p class="text-3xl pt-4">Podstawowe kategorie</p>
        <table class="table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Nazwa</th>
                    <th class="px-4 py-2">Ikona</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($defaultCategories as $category)
                <tr>
                    <td class="border px-4 py-2">{{ $category->name }}</td>
                    <td class="border px-4 py-2">
                        <img src="{{asset($category->icon)}}" style="max-height: 100px">
                    </td>
                </tr>
                @endforeach

                {{ $data->links() }}
            </tbody>
        </table>
    </div>
    @include('livewire.categories.create')
    @include('livewire.categories.delete')
    @include('livewire.categories.edit')
</div>
