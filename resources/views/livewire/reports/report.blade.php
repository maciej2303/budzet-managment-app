<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Raporty') }}
    </h2>
</x-slot>

<div class="sm:py-12">
    <div name='content' class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:shadow-md sm:rounded border border-gray-light">
            <div class="mx-auto p-4 lg:p-12 rounded-2xl">
                <div class="flex items-center flex-wrap">
                    <div class="w-full flex">
                        <x-jet-input type="text" class="w-full sm:w-1/3 my-4 mr-2" name="search" wire:model='search'
                            placeholder="Szukaj" />
                        <select name="category" type="category"
                            class="form-select shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full sm:w-1/3 my-4 mr-2"
                            x-ref="category" wire:model="category">
                            <option value="-1">Wybierz kategorię</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="mt-4">
                            <input
                                class="datepickerReport shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                                wire:model.lazy="dateFrom" id="dateFrom" />

                            <x-jet-input-error for="dateFrom" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <input
                                class="datepickerReport shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                wire:model="dateTo" id="dateTo" />

                            <x-jet-input-error for="dateTo" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/3">
                        <div class="mt-2">
                            <p>Saldo konta: {{ number_format($budget->balance, 2) }}</p>
                            <span class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Przychód:
                                <span class="text-green-500 ml-2">{{ number_format($incomes, 2) }} zł</span></span>
                            <span class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                </svg> Wydatki: <span class="text-red-500 ml-2">{{ number_format($expenses, 2) }}
                                    zł</span></span>
                        </div>
                        <div class="block">
                            @foreach ($categories as $category)
                            @if($category->sum != 0)
                            <div class="flex mx-6 py-4 flex-row flex-wrap">
                                <img class="w-12 h-auto p-2 mx-2 self-center" src="{{ asset($category->icon) }}">
                                <div class="text-sm mx-2 flex flex-col">
                                    <p class="">{{$category->name}}</p>
                                    <p class="font-bold">{{ $category->sum }} PLN</p>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-full md:w-2/3">
                        <canvas id="myChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="{{asset('js/budget/datepicker.js')}}"></script>
<script src="{{asset('js/reports/chart.js')}}"></script>
@endpush
