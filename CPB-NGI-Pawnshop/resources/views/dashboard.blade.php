<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Customers -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Customers</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $customerCount }}</p>
                            </div>
                            <div class="text-blue-500 text-4xl">👥</div>
                        </div>
                    </div>
                </div>

                <!-- Active Loans -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Active Loans</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $activeLoansCount }}</p>
                            </div>
                            <div class="text-green-500 text-4xl">📋</div>
                        </div>
                    </div>
                </div>

                <!-- Total Items -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Items</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $itemsCount }}</p>
                            </div>
                            <div class="text-purple-500 text-4xl">📦</div>
                        </div>
                    </div>
                </div>

                <!-- Total Loan Amount -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Loan Amount</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">💰 {{ number_format($totalLoanAmount, 2) }}</p>
                            </div>
                            <div class="text-yellow-500 text-4xl">💵</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Loans -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Recent Loans</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Loan #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($recentLoans as $loan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $loan->loan_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $loan->customer->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($loan->loan_amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $loan->due_date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($loan->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($loan->status === 'paid') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @endif">
                                                {{ $loan->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('loans.show', $loan) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No loans yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
