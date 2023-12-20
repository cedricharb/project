<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account Approval') }}
        </h2>
    </x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <!-- Account Approval Form -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Account Details -->
                        <div>
                            <p><strong>Account Number:</strong> {{ $account->account_number }}</p>
                            <p><strong>Currency:</strong> {{ $account->currency }}</p>
                            <p><strong>Balance:</strong> {{ $account->balance }}</p>
                            <p><strong>Status:</strong> {{ $account->status }}</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>