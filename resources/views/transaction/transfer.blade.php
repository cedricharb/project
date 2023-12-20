{{-- transfer.blade.php --}}

<x-app-layout>
    <div class="container">
        <h1 class="mb-4 text-2xl font-semibold">Fund Transfer</h1>

        {{-- Display success message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Display validation errors --}}
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transaction.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="from_account_id" class="block text-sm font-medium text-gray-600">From Account:</label>
                <input type="number" name="from_account_id" id="from_account_id" class="form-input mt-1 block w-full" placeholder="Enter account ID" required>
            </div>

            <div class="mb-4">
                <label for="to_account_id" class="block text-sm font-medium text-gray-600">To Account:</label>
                <input type="number" name="to_account_id" id="to_account_id" class="form-input mt-1 block w-full" placeholder="Enter account ID" required>
            </div>

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-600">Amount:</label>
                <input type="number" name="amount" id="amount" class="form-input mt-1 block w-full" placeholder="Enter amount" required>
            </div>

            <button type="submit" class="bg-white text-gray-800 px-4 py-2 rounded hover:bg-gray-200 focus:outline-none focus:shadow-outline-blue active:bg-gray-300">
                Transfer Funds
            </button>
        </form>
    </div>
</x-app-layout>
