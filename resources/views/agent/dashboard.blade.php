{{-- resources/views/agent/dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Banking Agent Dashboard
        </h2>
    </x-slot>

    <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="mt-4">
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Pending Account Approvals</h2>
                <!-- List of pending accounts for approval -->
                @forelse ($pendingAccounts as $account)
                    <div class="mt-2 p-4 bg-white dark:bg-gray-700 rounded shadow">
                        <p>Account Number: {{ $account->account_number }}</p>
                        <p>Client Name: {{ $account->user->name }}</p>
                        <p>Currency: {{ $account->currency }}</p>
                        <form action="{{ route('agent.disableAccount', $account->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to disable this account?');">
                                Disable Account
                            </button>
                        </form>
                    </div>
                @empty
                    <p>No pending accounts for approval.</p>
                @endforelse
            </div>

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Recent Transactions</h2>
                <!-- List of recent transactions -->
                @forelse ($recentTransactions as $transaction)
                    <div class="mt-2 p-4 bg-white dark:bg-gray-700 rounded shadow">
                        <p>Transaction Date: {{ $transaction->created_at->format('Y-m-d H:i:s') }}</p>
                        <p>Account Number: {{ $transaction->account->account_number }}</p>
                        <p>Type: {{ ucfirst($transaction->type) }}</p>
                        <p>Amount: {{ number_format($transaction->amount, 2) }}</p>
                        <!-- Add other transaction details you want to show -->
                    </div>
                @empty
                    <p>No recent transactions found.</p>
                @endforelse
            </div>

            <!-- Link to view all transactions -->
            <a href="{{ route('agent.allTransactions') }}" class="text-blue-600 dark:text-blue-400 hover:underline">View All Transactions</a>
        </div>
    </div>
</x-app-layout>