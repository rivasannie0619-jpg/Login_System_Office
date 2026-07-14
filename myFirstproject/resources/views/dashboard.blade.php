<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ✅ UPDATED PREMIUM INTERACTIVE CARDS ✅ -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
                
                <!-- Card 1: Visitors Today (Indigo Theme) -->
                <div class="group relative bg-white rounded-xl shadow-sm border-l-4 border-indigo-500 p-6 transition-all duration-300 ease-out hover:-translate-y-1.5 hover:shadow-xl hover:shadow-indigo-100 hover:bg-indigo-50/30">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider transition-colors duration-300 group-hover:text-indigo-600">{{ __('Visitors Today') }}</div>
                    <div class="text-4xl font-extrabold text-indigo-600 mt-3 transition-transform duration-300 group-hover:scale-105 inline-block">{{ $stats['today'] ?? 0 }}</div>
                </div>

                <!-- Card 2: Currently Inside (Emerald/Green Theme) -->
                <div class="group relative bg-white rounded-xl shadow-sm border-l-4 border-emerald-500 p-6 transition-all duration-300 ease-out hover:-translate-y-1.5 hover:shadow-xl hover:shadow-emerald-100 hover:bg-emerald-50/30">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider transition-colors duration-300 group-hover:text-emerald-600">{{ __('Currently Inside') }}</div>
                    <div class="text-4xl font-extrabold text-emerald-600 mt-3 transition-transform duration-300 group-hover:scale-105 inline-block">{{ $stats['currently_in'] ?? 0 }}</div>
                </div>

                <!-- Card 3: Denied Entry (Rose/Red Theme) -->
                <div class="group relative bg-white rounded-xl shadow-sm border-l-4 border-rose-500 p-6 transition-all duration-300 ease-out hover:-translate-y-1.5 hover:shadow-xl hover:shadow-rose-100 hover:bg-rose-50/30">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider transition-colors duration-300 group-hover:text-rose-600">{{ __('Denied Entry') }}</div>
                    <div class="text-4xl font-extrabold text-rose-600 mt-3 transition-transform duration-300 group-hover:scale-105 inline-block">{{ $stats['denied_entry'] ?? 0 }}</div>
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