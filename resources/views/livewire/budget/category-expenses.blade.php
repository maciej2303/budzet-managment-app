<div>
    <div class="rounded-t mb-0 px-0 border-0">
        <div class="flex flex-wrap items-center px-4 py-2">
            <div class="relative w-full max-w-full flex-grow flex-1">
                <h2 class="font-semibold text-lg text-gray-900 dark:text-gray-50">Wydatki na
                    kategorię</h2>
            </div>
        </div>
        <div class="block w-full overflow-x-auto" style="max-height: 320px">
            <table class="items-center w-full bg-transparent border-collapse">
                <tbody>
                    @foreach ($categoryExpenses->where('income', 0) as $category)
                    <tr>
                        <th
                            class="w-full border-t-0 px-4 pt-2 pb-2 align-middle border-l-0 border-r-0 text-left flex flex-row flex-wrap">
                            <img class="w-16 h-16 self-center" src="{{ asset($category->icon) }}">
                            <div class="text-sm mx-2 flex flex-col">
                                <p class="text-gray-600 text-sm">{{$category->name}}</p>
                                <p class="font-bold text-base">{{$category->expenses ?? 0}} PLN</p>
                            </div>
                        </th>
                        <td class="border-t-0 pt-2 pb-2 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap"
                            x-data="{ circumference: 2 * 22 / 7 * 20 }">
                            <div class=" relative flex items-center justify-center">
                                <svg class="transform -rotate-90 w-12 h-12">
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="8"
                                        fill="transparent" class="text-red-300" />

                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="8"
                                        fill="transparent" :stroke-dasharray="circumference"
                                        :stroke-dashoffset="circumference - {{$category->percentOfAllExpenses}} / 100 * circumference"
                                        class="text-red-500 " />
                                </svg>
                                <span class="absolute text-xs">{{round($category->percentOfAllExpenses, 0)}}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
