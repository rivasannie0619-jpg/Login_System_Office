<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Guest & Visitor Log') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('visitors.report') }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                    {{ __('Report') }}
                </a>
                <a href="{{ route('visitors.print', request()->query()) }}" target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                    {{ __('Print') }}
                </a>
                <button type="button" onclick="document.getElementById('add-visitor-modal').classList.remove('hidden')"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-gray-700 transition">
                    + {{ __('Add Visitor') }}
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ✅ Slim Layout: Search + Buttons Left, Filter Right -->
            <form method="GET" action="{{ route('visitors.index') }}" class="flex flex-col md:flex-row gap-3 items-center justify-between">
                <!-- Left Side: Slim Search + Tight Buttons -->
                <div class="flex flex-col sm:flex-row gap-1.5 w-60 md:w-auto items-center">
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                           placeholder="{{ __('Search...') }}"
                           class="w-60 sm:w-30  border-gray-300 rounded-md shadow-sm focus:ring-gray-800 focus:border-gray-800 text-sm px-3 py-2">

                    <div class="flex gap-1.5">
                        <button type="submit"
                                class="inline-flex items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-gray-700 transition whitespace-nowrap">
                            {{ __('Search') }}
                        </button>
                        <a href="{{ route('visitors.index') }}"
                           class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-600 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition whitespace-nowrap">
                            {{ __('Reset') }}
                        </a>
                    </div>
                </div>

                <!-- Right Side: Slim Filter -->
                <div class="w-60 md:w-48" text-align:left>
                    <select name="filter" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-gray-800 focus:border-gray-800 px-3 py-2">
                        <option value="">{{ __('Select Filter') }}</option>
                        <option value="today" @selected(($filters['filter'] ?? '') === 'today')>{{ __('Today') }}</option>
                        <option value="week" @selected(($filters['filter'] ?? '') === 'week')>{{ __('This Week') }}</option>
                        <option value="month" @selected(($filters['filter'] ?? '') === 'month')>{{ __('This Month') }}</option>
                        <option value="inside" @selected(($filters['filter'] ?? '') === 'inside')>{{ __('Currently Inside') }}</option>
                        <option value="checkedout" @selected(($filters['filter'] ?? '') === 'checkedout')>{{ __('Checked Out') }}</option>
                    </select>
                </div>
            </form>

            <!-- Table -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase text-xs min-w-[140px]">{{ __('Name') }}</th>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase text-xs min-w-[160px]">{{ __('From / Address') }}</th>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase text-xs min-w-[160px]">{{ __('Person to Visit') }}</th>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase text-xs min-w-[140px]">{{ __('Purpose') }}</th>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase text-xs min-w-[140px]">{{ __('Time In') }}</th>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase text-xs min-w-[140px]">{{ __('Time Out') }}</th>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase text-xs min-w-[120px]">{{ __('Status') }}</th>
                                <th class="px-5 py-4 text-right font-semibold text-gray-600 uppercase text-xs min-w-[140px]">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($visitors as $visitor)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 font-medium text-gray-800">{{ $visitor->name }}</td>
                                    <td class="px-5 py-4 text-gray-600">{{ $visitor->address }}</td>
                                    <td class="px-5 py-4 text-gray-600">{{ $visitor->person_to_visit }}</td>
                                    <td class="px-5 py-4 text-gray-600">{{ $visitor->purpose }}</td>
                                    <td class="px-5 py-4 text-gray-600">{{ $visitor->time_in->format('M d, Y h:i A') }}</td>
                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $visitor->time_out ? $visitor->time_out->format('M d, Y h:i A') : '—' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        @if ($visitor->time_out)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">{{ __('Checked Out') }}</span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">{{ __('Inside') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-right space-x-3 whitespace-nowrap">
                                        @unless ($visitor->time_out)
                                            <form method="POST" action="{{ route('visitors.checkout', $visitor) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="text-xs font-semibold text-emerald-700 hover:text-emerald-900">
                                                    {{ __('Check Out') }}
                                                </button>
                                            </form>
                                        @endunless
                                        <form method="POST" action="{{ route('visitors.destroy', $visitor) }}" class="inline"
                                        onsubmit="return confirm(@js(__('Are you sure you want to delete this record?'));">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-800">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-10 text-center text-gray-400">
                                        {{ __('No records found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-5 py-3 border-t border-gray-100">
                    {{ $visitors->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Visitor Modal -->
    <div id="add-visitor-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/50" onclick="document.getElementById('add-visitor-modal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Add New Visitor') }}</h3>

            <form method="POST" action="{{ route('visitors.store') }}" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="address" :value="__('From / Address')" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="person_to_visit" :value="__('Person to Visit')" />
                    <x-text-input id="person_to_visit" name="person_to_visit" type="text" class="mt-1 block w-full" :value="old('person_to_visit')" required />
                    <x-input-error :messages="$errors->get('person_to_visit')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="purpose" :value="__('Purpose of Visit')" />
                    <x-text-input id="purpose" name="purpose" type="text" class="mt-1 block w-full" :value="old('purpose')" required />
                    <x-input-error :messages="$errors->get('purpose')" class="mt-1" />
                </div>

                <p class="text-xs text-gray-400">{{ __('Entry time will be recorded automatically.') }}</p>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('add-visitor-modal').classList.add('hidden')"
                            class="px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        {{ __('Cancel') }}
                    </button>
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <script>document.getElementById('add-visitor-modal').classList.remove('hidden');</script>
    @endif
</x-app-layout>