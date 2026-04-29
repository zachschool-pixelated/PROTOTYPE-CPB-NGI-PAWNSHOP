<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Loan: ') }} {{ $loan->loan_number }}
            </h2>
            <div class="space-x-2">
                @if($loan->status === 'active')
                    <a href="{{ route('loans.edit', $loan) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        {{ __('Edit') }}
                    </a>
                @endif
                <a href="{{ route('loans.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Loan Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Loan Amount</p>
                        <p class="text-2xl font-bold">{{ number_format($loan->loan_amount, 2) }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Total Interest</p>
                        <p class="text-2xl font-bold">{{ number_format($loan->calculateInterest(), 2) }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Total Due</p>
                        <p class="text-2xl font-bold">{{ number_format($loan->total_due, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Customer & Loan Information -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-6">Loan Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Customer</p>
                            <p class="font-semibold"><a href="{{ route('customers.show', $loan->customer) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">{{ $loan->customer->name }}</a></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Created By</p>
                            <p class="font-semibold">{{ $loan->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Loan Date</p>
                            <p class="font-semibold">{{ $loan->loan_date->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Due Date</p>
                            <p class="font-semibold">{{ $loan->due_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Interest Rate</p>
                            <p class="font-semibold">{{ $loan->interest_rate }}%</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            <p class="font-semibold">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($loan->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($loan->status === 'paid') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ $loan->status_label }}
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($loan->notes)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Notes</p>
                            <p class="font-semibold">{{ $loan->notes }}</p>
                        </div>
                    @endif

                    @if($loan->status === 'active')
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex gap-4">
                            <form method="POST" action="{{ route('loans.mark-as-paid', $loan) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition" onclick="return confirm('Mark this loan as paid?')">
                                    {{ __('Mark as Paid') }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('loans.mark-as-forfeited', $loan) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition" onclick="return confirm('Mark this loan as forfeited?')">
                                    {{ __('Mark as Forfeited') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Items in Loan -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-6">Items in This Loan</h3>
                    
                    @if($loan->items->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Item</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Appraised Value</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Condition</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($loan->items as $loanItem)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 text-sm">
                                                <a href="{{ route('items.show', $loanItem->item) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                                                    {{ $loanItem->item->name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $loanItem->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ number_format($loanItem->appraised_value, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ ucfirst($loanItem->item->condition) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payments -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Payments</h3>
                        @if($loan->status === 'active')
                            <a href="{{ route('payments.create.for-loan', $loan->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                {{ __('+ Add Payment') }}
                            </a>
                        @endif
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Paid</p>
                            <p class="text-xl font-bold">{{ number_format($loan->total_paid, 2) }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Remaining Balance</p>
                            <p class="text-xl font-bold">{{ number_format($loan->remaining_balance, 2) }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Payment Progress</p>
                            <p class="text-xl font-bold">{{ round(($loan->total_paid / $loan->total_due) * 100, 2) }}%</p>
                        </div>
                    </div>

                    @if($loan->payments->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Method</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($loan->payments as $payment)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $payment->paid_at->format('M d, Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ number_format($payment->amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <form method="POST" action="{{ route('payments.destroy', $payment) }}" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400" onclick="return confirm('Delete this payment?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-6">No payments recorded yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
