<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Budżet') }}
    </h2>
</x-slot>

<div class="sm:py-12">
    <div name='content' class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:shadow-md sm:rounded border border-gray-light">
            <div class="mx-auto p-4 lg:p-12 rounded-2xl">
                <div class="grid grid-cols-1 lg:grid-cols-3 p-4 gap-4">
                    <div
                        class="relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded lg:col-span-2">
                        <div class="rounded-t mb-0 px-0 border-0">
                            <div class="px-4 py-2">
                                {{-- Sekcja miesięczna --}}
                                <div class="flex flex-wrap overflow-hidden">
                                    <div class="w-1/4 overflow-hidden flex items-center" wire:click="previousMonth">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                                        </svg>
                                    </div>

                                    <div class="w-1/2 overflow-hidden flex justify-center items-center">
                                        <div class="text-center">
                                            <p class="m-0">{{$months[$month]}}</p>
                                            <p class="text-xs">{{$year}}</p>
                                            <p class="font-bold text-xl">{{ number_format($budget->balance, 2) }}</p>
                                        </div>
                                    </div>

                                    <div class="w-1/4 overflow-hidden flex justify-end items-center"
                                        wire:click="nextMonth">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                {{-- Sekcja miesięczna --}}
                                {{-- Sekcja przychodow i wydatkow --}}
                                <div class="flex flex-wrap overflow-hidden pt-4">
                                    <div class="w-1/2 overflow-hidden flex justify-center">
                                        <div>
                                            <p class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                                </svg>
                                                Przychód:
                                            </p>
                                            <p class="text-green-500">
                                                {{ number_format($incomes, 2) }}
                                                zł</p>
                                        </div>
                                    </div>

                                    <div class="w-1/2 overflow-hidden flex justify-center">
                                        <div>
                                            <p class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                                </svg> Wydatki:
                                            </p>
                                            <p class="text-red-500">
                                                {{ number_format($expenses, 2) }}
                                                zł
                                            </p>
                                        </div>

                                    </div>
                                </div>
                                {{-- Sekcja przychodow i wydatkow --}}
                            </div>
                            <div class="px-4 py-2">
                                <div class="relative w-full max-w-full">
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-50 text-lg inline">Ostatnie
                                        transakcje</h3>
                                    <svg wire:click="operation" wire:loading.attr="disabled"
                                        xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline m-4 cursor-pointer"
                                        style="float: right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="block w-full overflow-x-auto" style="max-height: 600px">
                                <table class="items-center w-full bg-transparent border-collapse">
                                    <tbody>
                                        @forelse ($operations as $operation)

                                        <tr class="text-gray-700 dark:text-gray-100 hover:bg-gray-300"
                                            wire:click="showOperation({{$operation->id}})" wire:loading.attr="disabled">
                                            <th colspan="2"
                                                class="w-full border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left flex flex-row flex-wrap">
                                                <img class="w-16 h-auto self-center"
                                                    src="{{ asset($operation->category->icon) }}">
                                                <div class="text-sm mx-2 flex flex-col">
                                                    <p class="font-bold text-lg">{{ $operation->name}}</p>
                                                    <p class="text-xs">{{$operation->category->name}}</p>
                                                    <p class="text-xs">{{$operation->created_at->format('d.m.Y H:i')}}
                                                    </p>
                                                </div>
                                            </th>
                                            <td
                                                class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <p class="text-sm">{{$operation->value > 0 ? "PRZYCHÓD" : "WYDATEK"}}
                                                </p>
                                                <p
                                                    class="font-bold text-base {{$operation->value > 0 ? 'text-green-600' : 'text-red-600'}}">
                                                    {{ $operation->value}} PLN</p>
                                            </td>
                                        </tr>
                                        @empty
                                                <p class="px-4">Brak operacji</p>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div
                        class="relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded">

                        {{-- Próg wydatków --}}
                        <div class="rounded-t mb-0 p-2 border-0">
                            <div class="flex justify-center align-center pb-4">
                                <x-jet-button wire:click="thresholdModal" wire:loading.attr="disabled"
                                    style="width: 250px">
                                    {{ __('Ustaw miesięczny  próg wydatków') }}
                                </x-jet-button>
                            </div>
                            <div class="relative pt-1">
                                @if($budget->threshold > 0)
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-red-200 text-center w-full">
                                    <div style="width:{{$budget->currentMonthExpensesPercentage()}}%"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500">
                                    </div>
                                </div>
                                Wydano: {{number_format(abs($budget->currentMonthExpenses()),2)}} PLN /
                                {{number_format($budget->threshold, 2)}} PLN
                                @endif
                            </div>


                        </div>
                        {{-- Próg wydatków --}}

                        {{-- Miesięczne statystyki --}}
                        <div class="rounded-t mb-0 px-0 border-0">
                            <div class="flex flex-wrap items-center px-4 py-2">
                                <div class="relative w-full max-w-full flex-grow flex-1">
                                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-50">Miesięczne
                                        statystyki</h3>
                                </div>
                            </div>
                            <div class="block w-full">
                                <div style="height: 300px !important;">
                                    <livewire:livewire-line-chart key="{{ $chart->reactiveKey() }}"
                                        :line-chart-model="$chart" />
                                </div>
                            </div>
                        </div>
                        {{-- Miesięczne statystyki --}}

                        {{-- Wydatki na kategorię --}}
                        @livewire('budget.category-expenses', ['categoryExpenses' => $categoryExpenses, 'operations' => $operations, 'expenses' => $expenses], key('month'.$month.'year='.$year))
                        {{-- Wydatki na kategorię --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.budget.create')
    @include('livewire.budget.showOperation')
    @include('livewire.budget.threshold')
        @include('livewire.budget.delete')
</div>
@push('js')
<script>
    function hideAlert() {
        const target = document.getElementById("thresholdAlert");
        target.addEventListener('click', () => target.style.opacity = '0');
        target.addEventListener('transitionend', () => target.remove());
    }

</script>
@endpush
