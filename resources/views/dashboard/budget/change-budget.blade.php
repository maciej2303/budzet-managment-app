<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zamień budżet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex items-center justify-center mt-4">
                <p>Czy chcesz dołączyć do budżetu należącego do: {{$budget->owner->name}}</p>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <x-jet-button class="ml-4">
                        {{ __('Dołącz do budżetu') }}
                    </x-jet-button>
                </div>
                <div class="flex items-center justify-center my-4">
                    <x-jet-secondary-button class="ml-4">
                        {{ __('Anuluj') }}
                    </x-jet-secondary-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
