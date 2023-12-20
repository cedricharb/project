<!-- resources/views/bank-accounts/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Bank Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('bank-accounts.store') }}">
                        @csrf

                        <!-- Bank Account Information -->
                        <div>
                            <x-label for="account_type" :value="__('Account Type')" />
                            <x-select name="account_type" id="account_type">
                                <option value="savings">Savings</option>
                                <option value="current">Current</option>
                            </x-select>
                        </div>

                        <div class="mt-4">
                            <x-label for="currency" :value="__('Currency')" />
                            <x-select name="currency" id="currency">
                                <option value="LBP">LBP</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </x-select>
                        </div>

                        <!-- Other Bank Account Details -->
                        <!-- Add more fields as needed -->

                        <div class="flex items-center justify-end mt-4">
                            <x-button>
                                {{ __('Create Account') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
