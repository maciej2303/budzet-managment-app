<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Kategorie') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:shadow-md sm:rounded border border-gray-light min-h-screen">
            <div class="p-4 lg:p-12 rounded-2xl overflow-x-auto">

                <section class="container mx-auto pt-4">
                    <div class="relative flex justify-between items-center">
                        <span class="text-3xl py-4">Kategorie dodane do budżetu</span>
                        <x-jet-button wire:click="creating" wire:loading.attr="disabled" class="mr-2">
                            {{ __('Nowa kategoria') }}
                        </x-jet-button>
                    </div>
                    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full">
                                <thead class="text-center">
                                    <tr
                                        class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-300 uppercase border-b border-gray-600 text-center">
                                        <th class="px-4 py-2">Nazwa</th>
                                        <th class="px-4 py-2">Rodzaj</th>
                                        <th class="px-4 py-2">Ikona</th>
                                        <th class="px-4 py-2">Działania</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($data as $category)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $category->name }}</td>
                                        <td class="border px-4 py-2">
                                            <span
                                                class="font-bold text-base {{$category->income ? 'text-green-600' : 'text-red-600'}}">{{$category->income ? "PRZYCHODY" : "WYDATKI"}}
                                            </span>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <div class="flex justify-center">
                                                <img src="{{asset($category->icon)}}" style="max-height: 100px">
                                            </div>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <div class="flex justify-center flex-wrap">
                                                @if(auth()->user()->ownedBudget != null)
                                                <x-jet-button wire:click="editing({{ $category->id }})" class="mr-3"
                                                    wire:loading.attr="disabled">
                                                    {{ __('Edytuj') }}
                                                </x-jet-button>
                                                @endif
                                                @if($category->operations->isEmpty())
                                                    @if((auth()->id() == $category->user_id || auth()->user()->ownedBudget != null))
                                                    <x-jet-danger-button wire:click="deleting({{ $category->id }})"
                                                        wire:loading.attr="disabled">
                                                        {{ __('Usuń') }}
                                                    </x-jet-danger-button>
                                                    @endif
                                                @else
                                                    <div class="break w-full"></div>
                                                    <p class="text-base text-red-600 pt-2">Kategorii nie można usunąć ponieważ posiada dodane operację</p>
                                                @endif
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
                <p class="text-3xl pt-4">Podstawowe kategorie</p>

                <section class="container mx-auto font-mono pt-4">
                    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full text-center">
                                <thead>
                                    <tr
                                        class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-300 uppercase border-b border-gray-600 text-center">
                                        <th class="px-4 py-2">Nazwa</th>
                                        <th class="px-4 py-2">Rodzaj</th>
                                        <th class="px-4 py-2">Ikona</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($defaultCategories as $category)
                                    <tr>
                                        <td class="border px-2 py-2">
                                            {{ $category->name }}</td>
                                        <td class="border px-4 py-2">
                                            <span
                                                class="font-bold text-base {{$category->income ? 'text-green-600' : 'text-red-600'}}">{{$category->income ? "PRZYCHODY" : "WYDATKI"}}
                                            </span>
                                        </td>
                                        <td class="border px-4 py-2">
                                           <div class="flex justify-center">
                                                <img src="{{asset($category->icon)}}" style="max-height: 100px">
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
    @include('livewire.categories.create')
    @include('livewire.categories.delete')
    @include('livewire.categories.edit')
</div>
