<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('customers.update', $customer) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $customer->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $customer->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Phone Number')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $customer->phone)" required />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <textarea id="address" name="address" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>{{ old('address', $customer->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="id_type" :value="__('ID Type')" />
                            <select id="id_type" name="id_type" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                                <option value="">{{ __('Select ID Type') }}</option>
                                <option value="national_id" @selected(old('id_type', $customer->id_type) === 'national_id')>{{ __('National ID') }}</option>
                                <option value="passport" @selected(old('id_type', $customer->id_type) === 'passport')>{{ __('Passport') }}</option>
                                <option value="driver_license" @selected(old('id_type', $customer->id_type) === 'driver_license')>{{ __('Driver License') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('id_type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="id_number" :value="__('ID Number')" />
                            <x-text-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="old('id_number', $customer->id_number)" required />
                            <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="notes" :value="__('Notes')" />
                            <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('notes', $customer->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="is_active" :value="__('Status')" />
                            <div class="mt-2 flex items-center">
                                <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', $customer->is_active)) class="rounded dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                <label for="is_active" class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Active') }}</label>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <x-primary-button>{{ __('Update Customer') }}</x-primary-button>
                            <a href="{{ route('customers.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
