<x-guest-layout>
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <!-- Account Creation Form -->
    <form method="POST" action="{{ route('account.store') }}">
        @csrf

        <!-- Account Number -->
        <div class="mt-4 hidden">
            <x-input-label for="account_number" :value="__('Account Number')" />

            <x-text-input id="account_number" class="block mt-1 w-full" type="text" name="account_number" :value="old('account_number')" required readonly />

            <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
        </div>

        <!-- Currency -->
        <div class="mt-4">
            <x-input-label for="currency" :value="__('Currency')" />

            <select id="currency" name="currency" class="block mt-1 w-full" required>
                <option value="">Select Currency</option>
                <option value="LBP">LBP</option>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
            </select>

            <x-input-error :messages="$errors->get('currency')" class="mt-2" />
        </div>

        <!-- Balance -->
        <div class="mt-4">
            <x-input-label for="balance" :value="__('Initial Balance')" />

            <x-text-input id="balance" class="block mt-1 w-full" type="number" name="balance" :value="old('balance')" required />

            <x-input-error :messages="$errors->get('balance')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Create Account') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Generate Random Account Number Script -->
    <script>
        function generateAccountNumber() {
            // Example: Generate a random 10-digit account number
            const accountNumber = Math.floor(Math.random() * 9000000000) + 1000000000;
            document.getElementById('account_number').value = accountNumber;
        }

        // Generate a random account number when the page loads
        window.onload = generateAccountNumber;
    </script>
</x-guest-layout>