<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ✅ PASTE THE VISITOR STAT CARDS HERE ✅ -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-gray-800 p-5">
                    <div class="text-sm text-gray-500 uppercase tracking-wide">{{ __('Visitors Today') }}</div>
                    <div class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['today'] ?? 0 }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-emerald-500 p-5">
                    <div class="text-sm text-gray-500 uppercase tracking-wide">{{ __('Currently Inside') }}</div>
                    <div class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['currently_in'] ?? 0 }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500 p-5">
                    <div class="text-sm text-gray-500 uppercase tracking-wide">{{ __('This Week') }}</div>
                    <div class="text-3xl font-bold text-indigo-600 mt-1">{{ $stats['this_week'] ?? 0 }}</div>
                </div>
            </div>

            

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>