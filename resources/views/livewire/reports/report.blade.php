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
                                wire:model="dateFrom" id="dateFrom" />

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
                <div class="mt-2">
                    <p>Saldo konta: {{ number_format($budget->balance, 2) }}</p>
                    <span>Przychód: <span class="text-green-500">{{ number_format($incomes, 2) }}</span></span>
                    <span>Wydatki: <span class="text-red-500">{{ number_format($expenses, 2) }}</span></span>
                </div>
                <div class="block">
                    @foreach ($operations as $operation)
                    <div class="flex mx-6 py-4 flex-row flex-wrap">
                        <img class="w-12 h-auto p-2 mx-2 self-center" src="{{ asset($operation->category->icon) }}">
                        <div class="text-sm mx-2 flex flex-col">
                            <p class="">{{$operation->category->name}}</p>
                            <p class="font-bold">{{ $operation->value }} PLN</p>
                        </div>
                    </div>
                    @endforeach
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>

            </div>
        </div>
    </div>
</div>
@push('js')
<script src="{{asset('js/budget/datepicker.js')}}"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
@endpush
