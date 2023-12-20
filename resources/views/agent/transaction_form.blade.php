<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Execute Transaction
        </h2>
    </x-slot>

    <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-4">
            <form method="POST" action="{{ route('agent.executeTransaction') }}">
                @csrf

                <!-- Account Selection -->
                <div>
                    <label for="account_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Account</label>
                    <select id="account_id" name="account_id" required class="mt-1 block w-full">
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->account_number }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Transaction Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Transaction Type</label>
                    <select id="type" name="type" required class="mt-1 block w-full">
                        <option value="deposit">Deposit</option>
                        <option value="withdrawal">Withdrawal</option>
                    </select>
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Amount</label>
                    <input type="number" id="amount" name="amount" required min="0.01" step="0.01" class="mt-1 block w-full" />
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Execute Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>