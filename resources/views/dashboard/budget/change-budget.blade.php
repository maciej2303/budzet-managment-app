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
                    <form method="POST" action="{{ route('budget.change_budget', $budget) }}">
                        @csrf
                        @isset($members)
                        <div>
                            <x-jet-label>Aby dołączyć do tego budżetu, musisz przekazać właściciela innemu członkowi
                            </x-jet-label>
                            <select class="block w-full" name="owner_id">
                                @foreach ($members as $member)
                                <option value="{{$member->id}}">{{$member->name}} | {{$member->email}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endisset
                        <div class="flex items-center justify-center mt-4">
                            <x-jet-button>
                                {{ __('Dołącz do budżetu') }}
                            </x-jet-button>
                        </div>
                    </form>

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
