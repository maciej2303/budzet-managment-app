<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Budżet') }}
    </h2>
</x-slot>

<div class="sm:py-12">
    <div name='content' class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:shadow-md sm:rounded border border-gray-light">
            <div class="mx-auto p-4 lg:p-12 rounded-2xl">
                @if($budget->isThresholdExceeded())
                <div class="transition duration-500 bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-2 rounded relative"
                    role="alert" id="thresholdAlert">
                    <strong class="font-bold">Uwaga!</strong>
                    <span class="block sm:inline">Przekroczyłeś swój miesięczny próg wydatków.</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" onclick="hideAlert()">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
                @endif

                <x-jet-button wire:click="expense" wire:loading.attr="disabled">
                    {{ __('Dodaj wydatek') }}
                </x-jet-button>
                <x-jet-button wire:click="profit" wire:loading.attr="disabled">
                    {{ __('Dodaj przychód') }}
                </x-jet-button>
                <p class="mt-2">Saldo konta: {{ number_format($budget->balance, 2) }}</p>
                <p class="mt-2">Próg wydatkow: {{ number_format($budget->threshold, 2) }}</p>
                @if($budget->threshold > 0)
                <div class="relative pt-1">
                    <div class="overflow-hidden h-2 text-xs flex rounded bg-red-200">
                        <div style="width:{{$budget->currentMonthExpensesPercentage()}}%"
                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500">
                        </div>
                    </div>
                    Wydano: {{number_format(abs($budget->currentMonthExpenses()),2)}} /
                    {{number_format($budget->threshold, 2)}}
                </div>
                @endif
                <x-jet-button wire:click="thresholdModal" wire:loading.attr="disabled">
                    {{ __('Ustaw miesięczny  próg wydatków') }}
                </x-jet-button>
                <div class="grid grid-cols-1 lg:grid-cols-3 p-4 gap-4">
                    <div
                        class="relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded lg:col-span-2">
                        <div class="rounded-t mb-0 px-0 border-0">
                            <div class="flex flex-wrap items-center px-4 py-2">
                                <div class="relative w-full max-w-full flex-grow flex-1">
                                    <h3 class="font-semibold text-base text-gray-900 dark:text-gray-50">Budżet</h3>
                                </div>
                            </div>
                            <div class="block w-full overflow-x-auto">
                                <table class="items-center w-full bg-transparent border-collapse">
                                    <thead>
                                        <tr>
                                            <td class="pl-6">
                                                    <p class="flex">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                                    </svg>
                                                    Przychód:
                                                    </p>
                                                    <p
                                                        class="text-green-500">{{ number_format($budget->currentMonthIncomes(), 2) }}
                                                        zł</p>
                                            </td>
                                            <td class="">
                                                <p class="flex">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                                    </svg> Wydatki:
                                                </p>
                                                    <p
                                                        class="text-red-500">{{ number_format($budget->currentMonthExpenses(), 2) }}
                                                        zł
                                                    </p>
                                            </td>
                                            <td class="align-middle p-4 pl-0">
                                                <p>Saldo konta:</p>
                                                <p>{{ number_format($budget->balance, 2) }}</p>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="items-center w-full bg-transparent border-collapse">
                                    <tbody>
                                        @foreach ($budget->operations()->orderByDesc('created_at')->get(); as $operation)
                                        <tr class="text-gray-700 dark:text-gray-100">
                                            <th colspan="2"
                                                class="w-full border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left flex flex-row flex-wrap">
                                                <img class="w-12 h-auto p-2 mx-2 self-center"
                                                    src="{{ asset($operation->category->icon) }}">
                                                <div class="text-sm mx-2 flex flex-col">
                                                    <p class="font-bold text-lg">{{ $operation->name}}</p>
                                                    <p class="text-xs">{{$operation->category->name}}</p>
                                                    <p class="text-xs">{{$operation->created_at->format('d.m.Y H:i')}}</p>
                                                </div>
                                            </th>
                                            <td
                                                class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <p>{{$operation->value > 0 ? "PRZYCHÓD" : "WYDATEK"}}</p>
                                                <p
                                                    class="font-bold {{$operation->value > 0 ? 'text-green-300' : 'text-red-300'}}">
                                                    {{ $operation->value}} PLN</p>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div
                        class="relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded">
                        <div class="rounded-t mb-0 px-0 border-0">
                            <div class="flex flex-wrap items-center px-4 py-2">
                                <div class="relative w-full max-w-full flex-grow flex-1">
                                    <h3 class="font-semibold text-base text-gray-900 dark:text-gray-50">Miesięczne statystyki</h3>
                                </div>
                            </div>
                            <div class="block w-full overflow-x-auto">

                            </div>
                        </div>

                        <div class="rounded-t mb-0 px-0 border-0">
                            <div class="flex flex-wrap items-center px-4 py-2">
                                <div class="relative w-full max-w-full flex-grow flex-1">
                                    <h3 class="font-semibold text-base text-gray-900 dark:text-gray-50">Podział na operację</h3>
                                </div>
                            </div>
                            <div class="block w-full overflow-x-auto">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.budget.create')
    @include('livewire.budget.delete')
    {{-- @include('livewire.budget.edit') --}}
    @include('livewire.budget.threshold')
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
