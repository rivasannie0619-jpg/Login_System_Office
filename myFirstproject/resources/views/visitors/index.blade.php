<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
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

    <div class="py-8 w-full px-6">
        <div class="mx-auto space-y-6">

            @if (session('success'))
                <div class="rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" action="{{ route('visitors.index') }}" class="flex flex-col md:flex-row gap-3 items-center justify-between">
                <div class="flex flex-col sm:flex-row gap-1.5 items-center">
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                           placeholder="{{ __('Search...') }}"
                           class="w-64 border-gray-300 rounded-md shadow-sm focus:ring-gray-800 focus:border-gray-800 text-sm px-3 py-2">

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
            </form>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden w-full">
                <table class="w-full table-fixed divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-4 text-left font-semibold text-gray-600 uppercase text-xs w-[11%]">{{ __('Name') }}</th>
                            <th class="px-4 py-4 text-left font-semibold text-gray-600 uppercase text-xs w-[11%]">{{ __('Contact No.') }}</th>
                            <th class="px-4 py-4 text-left font-semibold text-gray-600 uppercase text-xs w-[12%]">{{ __('From / Address') }}</th>
                            <th class="px-4 py-4 text-left font-semibold text-gray-600 uppercase text-xs w-[12%]">{{ __('Person to Visit') }}</th>
                            <th class="px-4 py-4 text-left font-semibold text-gray-600 uppercase text-xs w-[10%]">{{ __('Purpose') }}</th>
                            <th class="px-4 py-4 text-left font-semibold text-gray-600 uppercase text-xs w-[10%]">{{ __('Time In') }}</th>
                            <th class="px-4 py-4 text-left font-semibold text-gray-600 uppercase text-xs w-[10%]">{{ __('Time Out') }}</th>
                            <th class="px-4 py-4 text-left font-semibold text-gray-600 uppercase text-xs w-[9%]">{{ __('Status') }}</th>
                            <th class="px-4 py-4 text-right font-semibold text-gray-600 uppercase text-xs w-[15%]">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($visitors as $visitor)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 font-medium text-gray-800 truncate">{{ $visitor->name }}</td>
                                <td class="px-4 py-4 text-gray-600">{{ $visitor->contact_no ?? '—' }}</td>
                                <td class="px-4 py-4 text-gray-600 truncate">{{ $visitor->address }}</td>
                                <td class="px-4 py-4 text-gray-600 truncate">{{ $visitor->person_to_visit }}</td>
                                <td class="px-4 py-4 text-gray-600 truncate">{{ $visitor->purpose }}</td>
                                <td class="px-4 py-4 text-gray-600 text-xs">{{ $visitor->time_in->format('M d, Y h:i A') }}</td>
                                <td class="px-4 py-4 text-gray-600 text-xs">
                                    {{ $visitor->time_out ? $visitor->time_out->format('M d, Y h:i A') : '—' }}
                                </td>
                                <td class="px-4 py-4">
                                    @if ($visitor->time_out)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">{{ __('Checked Out') }}</span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">{{ __('Inside') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right space-x-1.5 whitespace-nowrap">
                                    <button type="button" onclick="openViewModal({{ $visitor->id }})"
                                       class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                                        {{ __('View') }}
                                    </button>
                                    <button type="button" onclick="openEditModal({{ $visitor->id }})"
                                       class="text-xs font-semibold text-yellow-600 hover:text-yellow-800">
                                        {{ __('Edit') }}
                                    </button>
                                    @unless ($visitor->time_out)
                                        <form method="POST" action="{{ route('visitors.checkout', $visitor) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs font-semibold text-emerald-700 hover:text-emerald-900">
                                                {{ __('Check Out') }}
                                            </button>
                                        </form>
                                    @endunless
                                    <form method="POST" action="{{ route('visitors.destroy', $visitor) }}" class="inline"
                                    onsubmit="return confirm('{{ __('Are you sure you want to delete this record?') }}')">
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
                                <td colspan="9" class="px-5 py-10 text-center text-gray-400">
                                    {{ __('No records found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-5 py-3 border-t border-gray-100">
                    {{ $visitors->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Visitor Modal - Fixed Size & Fit -->
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
                    <div>
                        <x-input-label for="id_type" :value="__('ID Type')" class="text-xs" />
                        <x-text-input id="id_type" name="id_type" type="text" class="mt-1 block w-full text-sm py-1.5" :value="old('id_type')" placeholder="UMID, License" />
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

                <div>
                    <x-input-label for="purpose" :value="__('Purpose of Visit')" class="text-xs" />
                    <x-text-input id="purpose" name="purpose" type="text" class="mt-1 block w-full text-sm py-1.5" :value="old('purpose')" required />
                    <x-input-error :messages="$errors->get('purpose')" class="mt-1 text-xs" />
                </div>

                <p class="text-xs text-gray-400 pt-1">{{ __('Entry time will be recorded automatically.') }}</p>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('add-visitor-modal').classList.add('hidden')"
                            class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        {{ __('Cancel') }}
                    </button>
                    <x-primary-button class="px-3 py-1.5 text-xs">{{ __('Save') }}</x-primary-button>
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
                        class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
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
                <div>
                    <x-input-label for="edit_address" :value="__('From / Address')" class="text-xs" />
                    <x-text-input id="edit_address" name="address" type="text" class="mt-1 block w-full text-sm py-1.5" required />
                </div>
                <div>
                    <x-input-label for="edit_person_to_visit" :value="__('Person to Visit')" class="text-xs" />
                    <x-text-input id="edit_person_to_visit" name="person_to_visit" type="text" class="mt-1 block w-full text-sm py-1.5" required />
                </div>
                <div>
                    <x-input-label for="edit_purpose" :value="__('Purpose of Visit')" class="text-xs" />
                    <x-text-input id="edit_purpose" name="purpose" type="text" class="mt-1 block w-full text-sm py-1.5" required />
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')"
                            class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        {{ __('Cancel') }}
                    </button>
                    <x-primary-button class="px-3 py-1.5 text-xs">{{ __('Update') }}</x-primary-button>
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
            document.getElementById('edit_address').value = visitor.address;
            document.getElementById('edit_person_to_visit').value = visitor.person_to_visit;
            document.getElementById('edit_purpose').value = visitor.purpose;
            document.getElementById('edit-form').action = `/visitors/${id}`;
            document.getElementById('edit-modal').classList.remove('hidden');
        }
    </script>
</x-app-layout>