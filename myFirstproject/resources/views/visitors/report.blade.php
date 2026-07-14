<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Visitor Report') }}</h2>
            <a href="{{ route('visitors.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                {{ __('Back to Log') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" class="flex items-end gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">{{ __('Report Type') }}</label>
                        <select name="period" class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-gray-800 focus:border-gray-800">
                            <option value="daily" @selected($period === 'daily')>{{ __('Daily') }}</option>
                            <option value="weekly" @selected($period === 'weekly')>{{ __('Weekly') }}</option>
                        </select>
                    </div>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-gray-700 transition">
                        {{ __('Show') }}
                    </button>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-baseline justify-between mb-4">
                    <div>
                        <div class="text-sm text-gray-500">{{ $start->format('M d, Y') }} &ndash; {{ $end->format('M d, Y') }}</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $total }} {{ __('visitors') }}</div>
                    </div>
                </div>

                <table class="min-w-full text-sm divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Date') }}</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Total') }}</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Checked Out') }}</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('On-Site') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($perDay as $date => $row)
                            <tr>
                                <td class="px-3 py-2">{{ \Illuminate\Support\Carbon::parse($date)->format('M d, Y (D)') }}</td>
                                <td class="px-3 py-2 font-semibold">{{ $row['count'] }}</td>
                                <td class="px-3 py-2 text-gray-500">{{ $row['checked_out'] }}</td>
                                <td class="px-3 py-2 text-emerald-600">{{ $row['still_in'] }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-3 py-6 text-center text-gray-400">{{ __('No records for the selected period.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">{{ __('Most Visited') }}</h3>
                @forelse ($topHosts as $host => $count)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                        <span class="text-gray-700">{{ $host }}</span>
                        <span class="text-gray-500 text-sm">{{ $count }} {{ __('visitors') }}</span>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">{{ __('No data available yet.') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>