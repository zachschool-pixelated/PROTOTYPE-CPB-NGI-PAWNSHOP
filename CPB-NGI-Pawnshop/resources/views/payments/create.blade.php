<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Record Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('payments.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="loan_id" :value="__('Select Loan')" />
                            <select id="loan_id" name="loan_id" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required onchange="updateLoanInfo()">
                                <option value="">{{ __('Choose a loan...') }}</option>
                                @foreach($loans as $l)
                                    <option value="{{ $l->id }}" @selected($loan && $loan->id === $l->id)
                                        data-total-due="{{ $l->total_due }}"
                                        data-total-paid="{{ $l->total_paid }}"
                                        data-remaining="{{ $l->remaining_balance }}">
                                        {{ $l->loan_number }} - {{ $l->customer->name }} (Due: {{ number_format($l->remaining_balance, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('loan_id')" class="mt-2" />
                        </div>

                        <!-- Loan Summary -->
                        <div id="loan-summary" class="grid grid-cols-3 gap-4" style="display: none;">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Due</p>
                                <p class="text-lg font-bold" id="total-due">0.00</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Already Paid</p>
                                <p class="text-lg font-bold" id="total-paid">0.00</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Remaining</p>
                                <p class="text-lg font-bold" id="remaining">0.00</p>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="amount" :value="__('Payment Amount')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" :value="old('amount')" step="0.01" min="0.01" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Maximum: <span id="max-amount">0.00</span></p>
                        </div>

                        <div>
                            <x-input-label for="payment_method" :value="__('Payment Method')" />
                            <select id="payment_method" name="payment_method" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                                <option value="">{{ __('Select Payment Method') }}</option>
                                <option value="cash" @selected(old('payment_method') === 'cash')>{{ __('Cash') }}</option>
                                <option value="check" @selected(old('payment_method') === 'check')>{{ __('Check') }}</option>
                                <option value="card" @selected(old('payment_method') === 'card')>{{ __('Card') }}</option>
                                <option value="bank_transfer" @selected(old('payment_method') === 'bank_transfer')>{{ __('Bank Transfer') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="notes" :value="__('Notes')" />
                            <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex gap-4">
                            <x-primary-button>{{ __('Record Payment') }}</x-primary-button>
                            <a href="{{ route('payments.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateLoanInfo() {
            const select = document.getElementById('loan_id');
            const summary = document.getElementById('loan-summary');
            const option = select.options[select.selectedIndex];
            
            if (select.value) {
                document.getElementById('total-due').textContent = parseFloat(option.dataset.totalDue).toFixed(2);
                document.getElementById('total-paid').textContent = parseFloat(option.dataset.totalPaid).toFixed(2);
                document.getElementById('remaining').textContent = parseFloat(option.dataset.remaining).toFixed(2);
                document.getElementById('max-amount').textContent = parseFloat(option.dataset.remaining).toFixed(2);
                summary.style.display = 'grid';
            } else {
                summary.style.display = 'none';
            }
        }

        // Initialize on page load if loan is selected
        if (document.getElementById('loan_id').value) {
            updateLoanInfo();
        }
    </script>
</x-app-layout>
