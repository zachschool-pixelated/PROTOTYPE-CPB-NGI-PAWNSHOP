<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Item: ') }} {{ $item->name }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('items.edit', $item) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('items.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Item Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-6">Item Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Item Code</p>
                            <p class="font-semibold">{{ $item->item_code }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                            <p class="font-semibold">{{ $item->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Category</p>
                            <p class="font-semibold">{{ $item->category->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Appraised Value</p>
                            <p class="font-semibold">{{ number_format($item->appraised_value, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Condition</p>
                            <p class="font-semibold">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($item->condition === 'excellent') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($item->condition === 'good') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @elseif($item->condition === 'fair') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ ucfirst($item->condition) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            <p class="font-semibold">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($item->is_available) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ $item->is_available ? 'Available' : 'In Loan' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($item->location)
                        <div class="mt-6">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Storage Location</p>
                            <p class="font-semibold">{{ $item->location }}</p>
                        </div>
                    @endif

                    @if($item->description)
                        <div class="mt-6">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
                            <p class="font-semibold">{{ $item->description }}</p>
                        </div>
                    @endif

                    @if($item->notes)
                        <div class="mt-6">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Notes</p>
                            <p class="font-semibold">{{ $item->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Item Loans History -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-6">Loans History</h3>

                    @if($item->loans->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Loan #</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Loan Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Loan Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($item->loans as $loan)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $loan->loan_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $loan->customer->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($loan->loan_amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $loan->loan_date->format('M d, Y') }}</td>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-6">This item has not been part of any loans yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
