<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Raporty') }}
    </h2>
</x-slot>

<div class="sm:py-12">
    <div name='content' class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white sm:shadow-md sm:rounded border border-gray-light">
            <div class="mx-auto p-4 lg:p-12 rounded-2xl">
                <div class="flex items-center flex-wrap">
                    <div class="w-full flex">
                        <select name="period" wire:model="period" id="period"
                            class="form-select shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full sm:w-1/3 my-4 mr-2">
                            @foreach ($periods as $key => $periodSelect)
                            <option value="{{ $key }}" wire:key="{{$key}}">{{ $periodSelect }}</option>
                            @endforeach
                        </select>
                        <select name="category" type="category"
                            class="form-select shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full sm:w-1/3 my-4 mr-2"
                            x-ref="category" wire:model="category">
                            <option value="-1">Wybierz kategorię</option>
                            @foreach ($categories as $categorySelect)
                            <option value="{{ $categorySelect->id }}">{{ $categorySelect->name }}</option>
                            @endforeach
                        </select>
                        <select name="user" type="user"
                            class="form-select shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full sm:w-1/3 my-4 mr-2"
                            x-ref="user" wire:model="user">
                            <option value="-1">Wszyscy członkowie</option>
                            @foreach ($users as $userSelect)
                            <option value="{{ $userSelect->id }}">{{ $userSelect->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/3">
                        <div class="mt-2">
                            <p class="pl-6">Saldo konta: {{ number_format($budget->balance, 2) }} PLN</p>
                            <span class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Przychód:
                                <span class="text-green-500 ml-2">{{ number_format($incomes, 2) }} PLN</span></span>
                            <span class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                </svg> Wydatki: <span class="text-red-500 ml-2">{{ number_format($expenses, 2) }}
                                    PLN</span>
                            </span>
                        </div>
                        <div class="block">
                            @foreach ($categories as $categoryDisplay)
                            @if($categoryDisplay->sum != 0)
                            <div class="flex mx-6 py-4 flex-row flex-wrap">
                                <img class="w-12 h-auto p-2 mx-2 self-center" src="{{ asset($categoryDisplay->icon) }}">
                                <div class="text-sm mx-2 flex flex-col">
                                    <p class="">{{$categoryDisplay->name}}</p>
                                    <p class="font-bold">{{ $categoryDisplay->sum }} PLN</p>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-full md:w-2/3">
                        @if($category == -1)
                        <div style="height: 300px !important;"
                            class="{{($period == 'current_month' || $period == 'prev_month') ? 'line-chart' : ''}}">
                            <livewire:livewire-line-chart key="{{ $chart->reactiveKey() }}"
                                :line-chart-model="$chart" />
                        </div>
                        @endif
                        <div style="height: 300px !important;">
                            <livewire:livewire-column-chart key="{{ $incomeExpenseChart->reactiveKey() }}"
                                :column-chart-model="$incomeExpenseChart" />
                        </div>
                        @if($categoryExpenseChart != null)
                        <div style="height: 500px !important;">
                            <livewire:livewire-pie-chart key="{{ $categoryExpenseChart->reactiveKey() }}"
                                :pie-chart-model="$categoryExpenseChart" />
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="{{asset('js/budget/datepicker.js')}}"></script>
@endpush
