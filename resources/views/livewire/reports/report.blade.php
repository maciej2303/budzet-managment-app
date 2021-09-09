<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Raporty') }}
    </h2>
</x-slot>

<div class="sm:py-12">
    <div name='content' class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:shadow-md sm:rounded border border-gray-light">
            <div class="mx-auto p-4 lg:p-12 rounded-2xl">
                <div class="flex items-center flex-wrap pb-52">
                    <div class="w-full flex">
                        <x-jet-input type="text" class="w-full sm:w-1/3 my-4 mr-2" name="search" wire:model='search'
                            placeholder="Szukaj" />
                        <select name="category" type="category" class="form-select block w-full sm:w-1/3 my-4"
                            x-ref="category" wire:model="category">
                            <option value="-1">Wybierz kategorię</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="mt-4">
                            <x-jet-label for="dateFrom" value="{{ __('Od') }}" />
                            <input class="datepickerReport" wire:model="dateFrom" id="dateFrom" />

                            <x-jet-input-error for="dateFrom" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="dateTo" value="{{ __('Do') }}" />
                            <input class="datepickerReport" wire:model="dateTo" id="dateTo" />

                            <x-jet-input-error for="dateTo" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="{{asset('js/budget/datepicker.js')}}"></script>
@endpush
