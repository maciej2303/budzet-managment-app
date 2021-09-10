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
                        @livewire('datepicker')
                    </div>
                    <div>
                        <p class="mt-2">Saldo konta: {{ number_format($budget->balance, 2) }}</p>
                        <div
                            class="group flex items-center bg-indigo-900 bg-opacity-40 shadow-xl gap-5 px-6 py-5 rounded-lg ring-2 ring-offset-2 ring-offset-blue-800 ring-cyan-700 mt-5 cursor-pointer hover:bg-blue-900 hover:bg-opacity-100 transition">
                            <img class="w-9"
                                src="data:image/svg+xml,%3C?xml version='1.0' encoding='utf-8'?%3E %3C!-- Generator: Adobe Illustrator 22.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0) --%3E %3Csvg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 80 80' style='enable-background:new 0 0 80 80;' xml:space='preserve'%3E %3Cstyle type='text/css'%3E .st0%7Bfill:%23DD0031;%7D .st1%7Bfill:%23C3002F;%7D .st2%7Bfill:%23FFFFFF;%7D %3C/style%3E %3Cg%3E %3Cpolygon class='st0' points='40,0 40,0 40,0 2.8,13.3 8.4,62.5 40,80 40,80 40,80 71.6,62.5 77.2,13.3 '/%3E %3Cpolygon class='st1' points='40,0 40,8.9 40,8.8 40,49.4 40,49.4 40,80 40,80 71.6,62.5 77.2,13.3 '/%3E %3Cpath class='st2' d='M40,8.8L16.7,61l0,0h8.7l0,0l4.7-11.7h19.8L54.5,61l0,0h8.7l0,0L40,8.8L40,8.8L40,8.8L40,8.8L40,8.8z M46.8,42.2H33.2L40,25.8L46.8,42.2z'/%3E %3C/g%3E %3C/svg%3E"
                                alt="" />
                            <div>
                                <span>Angular</span>
                                <span class="text-xs text-blue-300 block">Typescript</span>
                            </div>
                            <div>
                                <i
                                    class="fa fa-chevron-right opacity-0 group-hover:opacity-100 transform -translate-x-1 group-hover:translate-x-0 block transition"></i>
                            </div>
                        </div>

                    </div>
                    <div class="block">
                        @foreach ($operations as $operation)
                        <div class="flex mx-6 py-4 flex-row flex-wrap">
                            <img class="w-12 h-12 p-2 mx-2 self-center" src="{{ asset($operation->category->icon) }}"
                                style="max-height: 40px">
                            <div class="text-sm mx-2 flex flex-col">
                                <p class="">Standard Ticket</p>
                                <p class="font-bold">{{ $operation->value }}</p>
                                <p class="text-xs text-gray-500">Price per adult</p>
                            </div>
                            <button
                                class="w-32 h-11 rounded flex border-solid border bg-white mx-2 justify-center place-items-center">
                                <div class="">Book</div>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="{{asset('js/budget/datepicker.js')}}"></script>
@endpush
