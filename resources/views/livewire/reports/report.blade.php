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
                    <div class="w-full">
                        <select name="period" wire:model="period" id="period"
                            class="form-select shadow appearance-none border rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full sm:w-1/4 mr-4 my-1">
                            @foreach ($periods as $key => $periodSelect)
                            <option value="{{ $key }}" wire:key="{{$key}}">{{ $periodSelect }}</option>
                            @endforeach
                        </select>
                        <select name="category" type="category"
                            class="form-select shadow appearance-none border rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full sm:w-1/4 mr-4 my-1"
                            x-ref="category" wire:model="category">
                            <option value="-1">Wybierz kategorię</option>
                            @foreach ($categories as $categorySelect)
                            <option value="{{ $categorySelect->id }}">{{ $categorySelect->name }}</option>
                            @endforeach
                        </select>
                        <select name="user" type="user"
                            class="form-select shadow appearance-none border rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full sm:w-1/4 my-1"
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
                            <p class="pl-6 flex justify-center sm:justify-start">Saldo konta: {{ number_format($budget->balance, 2) }} PLN</p>
                            <span class="flex justify-center sm:justify-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                Przychód:
                                <span class="text-green-500 ml-2">{{ number_format($incomes, 2) }} PLN</span>
                            </span>
                            <span class="flex justify-center sm:justify-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                </svg> Wydatki: <span class="text-red-500 ml-2">{{ number_format($expenses, 2) }}
                                    PLN</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="pt-2">
                    @if($category == -1 && $user == -1)
                    <div style="height: 300px !important;"
                        class="{{($period == 'current_month' || $period == 'prev_month') ? 'line-chart' : ''}}">
                        <livewire:livewire-line-chart key="{{ $chart->reactiveKey() }}" :line-chart-model="$chart" />
                    </div>
                    @endif
                    <div style="height: 300px !important;" class="p52">
                        <p class="text-center font-black" style="font-size: 14px">Wykres przychodów i wydatków</p>
                        <livewire:livewire-column-chart key="{{ $incomeExpenseChart->reactiveKey() }}"
                            :column-chart-model="$incomeExpenseChart" />
                    </div>
                    @if($categoryExpenseChart != null)
                    <div style="height: 500px !important;" class="pt-6">
                        <livewire:livewire-pie-chart key="{{ $categoryExpenseChart->reactiveKey() }}"
                            :pie-chart-model="$categoryExpenseChart" />
                    </div>
                    @endif
                    @if($categoryIncomeChart != null)
                    <div style="height: 500px !important;" class="pt-6">
                        <livewire:livewire-pie-chart key="{{ $categoryIncomeChart->reactiveKey() }}"
                            :pie-chart-model="$categoryIncomeChart" />
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div
    x-data="{ loading: false }"
    x-show="loading"
    @loading.window="loading = $event.detail.loading"
>
    <style>
        .loader {
            border-top-color: #3498db;
            -webkit-animation: spinner 1.5s linear infinite;
            animation: spinner 1.5s linear infinite;
        }

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spinner {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div
        class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 opacity-75 flex flex-col items-center justify-center">
        <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
        <h2 class="text-center text-white dark:text-fuchsia-600 text-xl font-semibold">Trwa ładowanie raportów....</h2>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        this.livewire.hook('message.sent', () => {
            window.dispatchEvent(
                new CustomEvent('loading', { detail: { loading: true }})
            );
        } )
        this.livewire.hook('message.processed', (message, component) => {
            window.dispatchEvent(
                new CustomEvent('loading', { detail: { loading: false }})
            );
        })
    });
</script>
@push('js')
<script src="{{asset('js/budget/datepicker.js')}}"></script>
@endpush
