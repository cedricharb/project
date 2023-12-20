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
                    <form method="POST" action="{{ route('account.updateApproval', $account->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Account ID (Hidden) -->
                        <input type="hidden" name="account_id" value="{{ $account->id }}">

                        <!-- Account Details -->
                        <div>
                            <p><strong>Account Number:</strong> {{ $account->account_number }}</p>
                            <p><strong>User ID:</strong> {{ $account->user_id }}</p>
                            <p><strong>Currency:</strong> {{ $account->currency }}</p>
                            <p><strong>Balance:</strong> {{ $account->balance }}</p>
                            <p><strong>Status:</strong> {{ $account->status }}</p>
                        </div>

                        <!-- Approval Selection -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Set Account Status')" />
                            <select id="status" name="status" class="block mt-1 w-full" required>
                                <option value="pending" {{ $account->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $account->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                <option value="disapproved" {{ $account->status == 'disapproved' ? 'selected' : '' }}>Disapprove</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Status') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>