<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Guest & Visitor Log') }}
            </h2>
            <div class="flex items-center gap-2">
                <!-- Report Button (Premium Hover & Lift Effect) -->
                <a href="{{ route('visitors.report') }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-lg font-bold text-xs text-slate-500 uppercase tracking-wider shadow-sm hover:shadow-md hover:bg-slate-50 hover:text-slate-700 hover:-translate-y-0.5 active:scale-95 transition-all duration-150 transform">
                    {{ __('Report') }}
                </a>
                
                <!-- Print Button (Premium Hover & Lift Effect) -->
                <a href="{{ route('visitors.print', request()->query()) }}" target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-lg font-bold text-xs text-slate-500 uppercase tracking-wider shadow-sm hover:shadow-md hover:bg-slate-50 hover:text-slate-700 hover:-translate-y-0.5 active:scale-95 transition-all duration-150 transform">
                    {{ __('Print') }}
                </a>
                
                <!-- + ADD VISITOR Button -->
                <button type="button" onclick="document.getElementById('add-visitor-modal').classList.remove('hidden')"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider rounded-lg shadow-md shadow-indigo-500/20 hover:shadow-lg active:scale-95 transition-all duration-150 transform hover:-translate-y-0.5">
                    + {{ __('Add Visitor') }}
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8 w-full px-6">
        <div class="mx-auto space-y-6">

            @if (session('success'))
                <div class="rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search & Filter Bar Section -->
            <form method="GET" action="{{ route('visitors.index') }}" class="flex items-center gap-2.5">
                <!-- Search Input -->
                <div class="relative w-64 flex items-center">
                    <div class="absolute left-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                           placeholder="{{ __('Search..') }}"
                           class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-all duration-150">
                </div>

                <!-- APPLY Button (Premium Hover, Shadow & Lift Effect) -->
                <button type="submit"
                        class="inline-flex items-center px-5 py-2 bg-indigo-600 hover:bg-indigo-700 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-wider shadow-sm hover:shadow-lg hover:shadow-indigo-500/20 active:scale-95 hover:-translate-y-0.5 transition-all duration-150 transform whitespace-nowrap">
                    {{ __('Apply') }}
                </button>
                
                <!-- RESET Button (Premium Hover, Shadow & Lift Effect) -->
                <a href="{{ route('visitors.index') }}"
                   class="inline-flex items-center px-5 py-2 bg-white border border-slate-200 rounded-lg font-bold text-xs text-slate-400 uppercase tracking-wider shadow-sm hover:shadow-md hover:bg-slate-50 hover:text-slate-600 active:scale-95 hover:-translate-y-0.5 transition-all duration-150 transform whitespace-nowrap">
                    {{ __('Reset') }}
                </a>
            </form>

            <!-- Table Card -->
            <div class="bg-white shadow-sm rounded-xl overflow-hidden w-full border border-slate-100">
                <table class="w-full table-fixed divide-y divide-slate-100 text-sm">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-4 py-4 text-left font-bold text-slate-400 uppercase text-xs w-[11%]">{{ __('Name') }}</th>
                            <th class="px-4 py-4 text-left font-bold text-slate-400 uppercase text-xs w-[11%]">{{ __('Contact No.') }}</th>
                            <th class="px-4 py-4 text-left font-bold text-slate-400 uppercase text-xs w-[12%]">{{ __('From / Address') }}</th>
                            <th class="px-4 py-4 text-left font-bold text-slate-400 uppercase text-xs w-[12%]">{{ __('Person to Visit') }}</th>
                            <th class="px-4 py-4 text-left font-bold text-slate-400 uppercase text-xs w-[10%]">{{ __('Purpose') }}</th>
                            <th class="px-4 py-4 text-left font-bold text-slate-400 uppercase text-xs w-[10%]">{{ __('Time In') }}</th>
                            <th class="px-4 py-4 text-left font-bold text-slate-400 uppercase text-xs w-[10%]">{{ __('Time Out') }}</th>
                            <th class="px-4 py-4 text-left font-bold text-slate-400 uppercase text-xs w-[10%]">{{ __('Status') }}</th>
                            <th class="px-4 py-4 text-right font-bold text-slate-400 uppercase text-xs w-[10%]">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($visitors as $visitor)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-4 py-4 font-semibold text-slate-800 truncate">{{ $visitor->name }}</td>
                                <td class="px-4 py-4 text-slate-500">{{ $visitor->contact_no ?? '—' }}</td>
                                <td class="px-4 py-4 text-slate-500 truncate">{{ $visitor->address }}</td>
                                <td class="px-4 py-4 text-slate-500 truncate font-medium">{{ $visitor->person_to_visit }}</td>
                                <td class="px-4 py-4 text-slate-500 truncate">{{ $visitor->purpose }}</td>
                                <td class="px-4 py-4 text-slate-400 text-xs">{{ $visitor->time_in->format('M d, Y h:i A') }}</td>
                                <td class="px-4 py-4 text-slate-400 text-xs">
                                    {{ $visitor->time_out ? $visitor->time_out->format('M d, Y h:i A') : '—' }}
                                </td>
                                
                                <!-- Status Column -->
                                <td class="px-4 py-4">
                                    @if ($visitor->time_out)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200">
                                            {{ __('OUT') }}
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15H19M9 5a9 9 0 0112.42 7.22"></path>
                                            </svg>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ __('Inside') }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions Section -->
                                <td class="px-4 py-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-0.5">
                                        <!-- OUT Action Button -->
                                        @unless ($visitor->time_out)
                                            <form method="POST" action="{{ route('visitors.checkout', $visitor) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" title="Check Out" class="p-1 rounded-md bg-emerald-50 text-emerald-600 hover:bg-emerald-100 active:scale-90 transition-all">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <div class="w-7 h-7"></div>
                                        @endunless

                                        <!-- View Icon -->
                                        <button type="button" onclick="openViewModal({{ $visitor->id }})" title="View"
                                           class="p-1 rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 active:scale-90 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>

                                        <!-- Edit Icon -->
                                        <button type="button" onclick="openEditModal({{ $visitor->id }})" title="Edit"
                                           class="p-1 rounded-md bg-indigo-50 text-indigo-600 hover:bg-indigo-100 active:scale-90 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </button>

                                        <!-- Delete Icon -->
                                        <form method="POST" action="{{ route('visitors.destroy', $visitor) }}" class="inline"
                                              onsubmit="return confirm('{{ __('Are you sure you want to delete this record?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete" class="p-1 rounded-md bg-rose-50 text-rose-600 hover:bg-rose-100 active:scale-90 transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 11-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-10 text-center text-slate-400">
                                    {{ __('No records found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/30">
                    {{ $visitors->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Visitor Modal -->
    <div id="add-visitor-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/50" onclick="document.getElementById('add-visitor-modal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md p-5">
            <h3 class="text-base font-semibold text-gray-800 mb-3">{{ __('Add New Visitor') }}</h3>
            <form method="POST" action="{{ route('visitors.store') }}" class="space-y-3">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-xs" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-sm py-1.5" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
                </div>

                <div>
                    <x-input-label for="contact_no" :value="__('Contact Number')" class="text-xs" />
                    <x-text-input id="contact_no" name="contact_no" type="text" class="mt-1 block w-full text-sm py-1.5" :value="old('contact_no')" />
                    <x-input-error :messages="$errors->get('contact_no')" class="mt-1 text-xs" />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <!-- Dropdown for ID Type -->
                    <div>
                        <x-input-label for="id_type" :value="__('ID Type')" class="text-xs" />
                        <select id="id_type" name="id_type" 
                                class="mt-1 block w-full text-sm py-1.5 border border-slate-200 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                            <option value="">{{ __('Select ID Type') }}</option>
                            <option value="National ID" {{ old('id_type') == 'National ID' ? 'selected' : '' }}>National ID</option>
                            <option value="UMID" {{ old('id_type') == 'UMID' ? 'selected' : '' }}>UMID</option>
                            <option value="Driver License" {{ old('id_type') == 'Driver License' ? 'selected' : '' }}>Driver's License</option>
                            <option value="Passport" {{ old('id_type') == 'Passport' ? 'selected' : '' }}>Passport</option>
                            <option value="SSS / GSIS ID" {{ old('id_type') == 'SSS / GSIS ID' ? 'selected' : '' }}>SSS / GSIS ID</option>
                            <option value="Postal ID" {{ old('id_type') == 'Postal ID' ? 'selected' : '' }}>Postal ID</option>
                            <option value="PRC ID" {{ old('id_type') == 'PRC ID' ? 'selected' : '' }}>PRC ID</option>
                            <option value="School / Company ID" {{ old('id_type') == 'School / Company ID' ? 'selected' : '' }}>School / Company ID</option>
                        </select>
                        <x-input-error :messages="$errors->get('id_type')" class="mt-1 text-xs" />
                    </div>
                    <div>
                        <x-input-label for="id_number" :value="__('ID Number')" class="text-xs" />
                        <x-text-input id="id_number" name="id_number" type="text" class="mt-1 block w-full text-sm py-1.5" :value="old('id_number')" />
                        <x-input-error :messages="$errors->get('id_number')" class="mt-1 text-xs" />
                    </div>
                </div>

                <div>
                    <x-input-label for="address" :value="__('From / Address')" class="text-xs" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full text-sm py-1.5" :value="old('address')" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-1 text-xs" />
                </div>

                <div>
                    <x-input-label for="person_to_visit" :value="__('Person to Visit')" class="text-xs" />
                    <x-text-input id="person_to_visit" name="person_to_visit" type="text" class="mt-1 block w-full text-sm py-1.5" :value="old('person_to_visit')" required />
                    <x-input-error :messages="$errors->get('person_to_visit')" class="mt-1 text-xs" />
                </div>

                <!-- Dropdown for Purpose of Visit -->
                <div>
                    <x-input-label for="purpose" :value="__('Purpose of Visit')" class="text-xs" />
                    <select id="purpose" name="purpose" required
                            class="mt-1 block w-full text-sm py-1.5 border border-slate-200 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                        <option value="">{{ __('Select Purpose') }}</option>
                        <option value="Meeting" {{ old('purpose') == 'Meeting' ? 'selected' : '' }}>Meeting</option>
                        <option value="Job Interview" {{ old('purpose') == 'Job Interview' ? 'selected' : '' }}>Job Interview</option>
                        <option value="Personal Visit" {{ old('purpose') == 'Personal Visit' ? 'selected' : '' }}>Personal Visit</option>
                        <option value="Delivery / Courier" {{ old('purpose') == 'Delivery / Courier' ? 'selected' : '' }}>Delivery / Courier</option>
                        <option value="Maintenance / Repair" {{ old('purpose') == 'Maintenance / Repair' ? 'selected' : '' }}>Maintenance / Repair</option>
                        <option value="Official Business" {{ old('purpose') == 'Official Business' ? 'selected' : '' }}>Official Business</option>
                        <option value="Other" {{ old('purpose') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <x-input-error :messages="$errors->get('purpose')" class="mt-1 text-xs" />
                </div>

                <p class="text-xs text-gray-400 pt-1">{{ __('Entry time will be recorded automatically.') }}</p>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('add-visitor-modal').classList.add('hidden')"
                            class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 active:scale-95 transition-all">
                        {{ __('Cancel') }}
                    </button>
                    <x-primary-button class="px-3 py-1.5 text-xs active:scale-95 transition-all">{{ __('Save') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Visitor Modal -->
    <div id="view-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/50" onclick="document.getElementById('view-modal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md p-5">
            <h3 class="text-base font-semibold text-gray-800 mb-3">{{ __('Visitor Details') }}</h3>
            <div id="view-content" class="space-y-1.5 text-sm text-gray-600"></div>
            <div class="flex justify-end mt-4">
                <button type="button" onclick="document.getElementById('view-modal').classList.add('hidden')"
                        class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 active:scale-95 transition-all">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Visitor Modal -->
    <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/50" onclick="document.getElementById('edit-modal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md p-5">
            <h3 class="text-base font-semibold text-gray-800 mb-3">{{ __('Edit Visitor') }}</h3>
            <form id="edit-form" method="POST" class="space-y-3">
                @csrf @method('PUT')
                <div>
                    <x-input-label for="edit_name" :value="__('Name')" class="text-xs" />
                    <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full text-sm py-1.5" required />
                </div>
                <div>
                    <x-input-label for="edit_contact_no" :value="__('Contact Number')" class="text-xs" />
                    <x-text-input id="edit_contact_no" name="contact_no" type="text" class="mt-1 block w-full text-sm py-1.5" />
                </div>
                <!-- Edit ID Type Dropdown -->
                <div>
                    <x-input-label for="edit_id_type" :value="__('ID Type')" class="text-xs" />
                    <select id="edit_id_type" name="id_type" 
                            class="mt-1 block w-full text-sm py-1.5 border border-slate-200 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                        <option value="">{{ __('Select ID Type') }}</option>
                        <option value="National ID">National ID</option>
                        <option value="UMID">UMID</option>
                        <option value="Driver License">Driver's License</option>
                        <option value="Passport">Passport</option>
                        <option value="SSS / GSIS ID">SSS / GSIS ID</option>
                        <option value="Postal ID">Postal ID</option>
                        <option value="PRC ID">PRC ID</option>
                        <option value="School / Company ID">School / Company ID</option>
                    </select>
                </div>
                <!-- Edit ID Number -->
                <div>
                    <x-input-label for="edit_id_number" :value="__('ID Number')" class="text-xs" />
                    <x-text-input id="edit_id_number" name="id_number" type="text" class="mt-1 block w-full text-sm py-1.5" />
                </div>
                <div>
                    <x-input-label for="edit_address" :value="__('From / Address')" class="text-xs" />
                    <x-text-input id="edit_address" name="address" type="text" class="mt-1 block w-full text-sm py-1.5" required />
                </div>
                <div>
                    <x-input-label for="edit_person_to_visit" :value="__('Person to Visit')" class="text-xs" />
                    <x-text-input id="edit_person_to_visit" name="person_to_visit" type="text" class="mt-1 block w-full text-sm py-1.5" required />
                </div>
                <!-- Edit Purpose Dropdown -->
                <div>
                    <x-input-label for="edit_purpose" :value="__('Purpose of Visit')" class="text-xs" />
                    <select id="edit_purpose" name="purpose" required
                            class="mt-1 block w-full text-sm py-1.5 border border-slate-200 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                        <option value="">{{ __('Select Purpose') }}</option>
                        <option value="Meeting">Meeting</option>
                        <option value="Job Interview">Job Interview</option>
                        <option value="Personal Visit">Personal Visit</option>
                        <option value="Delivery / Courier">Delivery / Courier</option>
                        <option value="Maintenance / Repair">Maintenance / Repair</option>
                        <option value="Official Business">Official Business</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')"
                            class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 active:scale-95 transition-all">
                        {{ __('Cancel') }}
                    </button>
                    <x-primary-button class="px-3 py-1.5 text-xs active:scale-95 transition-all">{{ __('Update') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <script>document.getElementById('add-visitor-modal').classList.remove('hidden');</script>
    @endif

    <script>
        async function openViewModal(id) {
            const res = await fetch(`/visitors/${id}`);
            const visitor = await res.json();
            document.getElementById('view-content').innerHTML = `
                <div class="flex gap-2"><strong class="w-32 text-gray-800">Name:</strong> ${visitor.name}</div>
                <div class="flex gap-2"><strong class="w-32 text-gray-800">Contact No.:</strong> ${visitor.contact_no || '—'}</div>
                <div class="flex gap-2"><strong class="w-32 text-gray-800">ID Type:</strong> ${visitor.id_type || '—'}</div>
                <div class="flex gap-2"><strong class="w-32 text-gray-800">ID Number:</strong> ${visitor.id_number || '—'}</div>
                <div class="flex gap-2"><strong class="w-32 text-gray-800">Address:</strong> ${visitor.address}</div>
                <div class="flex gap-2"><strong class="w-32 text-gray-800">Visiting:</strong> ${visitor.person_to_visit}</div>
                <div class="flex gap-2"><strong class="w-32 text-gray-800">Purpose:</strong> ${visitor.purpose}</div>
                <div class="flex gap-2"><strong class="w-32 text-gray-800">Time In:</strong> ${new Date(visitor.time_in).toLocaleString()}</div>
                <div class="flex gap-2"><strong class="w-32 text-gray-800">Time Out:</strong> ${visitor.time_out ? new Date(visitor.time_out).toLocaleString() : 'Still Inside'}</div>
            `;
            document.getElementById('view-modal').classList.remove('hidden');
        }
        async function openEditModal(id) {
            const res = await fetch(`/visitors/${id}/edit`);
            const visitor = await res.json();
            document.getElementById('edit_name').value = visitor.name;
            document.getElementById('edit_contact_no').value = visitor.contact_no || '';
            document.getElementById('edit_id_type').value = visitor.id_type || '';
            document.getElementById('edit_id_number').value = visitor.id_number || '';
            document.getElementById('edit_address').value = visitor.address;
            document.getElementById('edit_person_to_visit').value = visitor.person_to_visit;
            document.getElementById('edit_purpose').value = visitor.purpose;
            document.getElementById('edit-form').action = `/visitors/${id}`;
            document.getElementById('edit-modal').classList.remove('hidden');
        }
    </script>
</x-app-layout>