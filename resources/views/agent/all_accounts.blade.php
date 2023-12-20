{{-- resources/views/agent/all_accounts.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Accounts
        </h2>
    </x-slot>

    <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="mt-4">
            <table class="min-w-full table-auto bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                            Account Number
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                            Client Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                            Currency
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                            Balance
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($accounts as $account)
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            {{ $account->account_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $account->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $account->currency }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ number_format($account->balance, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ ucfirst($account->status) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <form action="{{ route('agent.account.approve', $account->id) }}" method="POST">
                            <button class="text-blue-600 dark:text-blue-400 hover:underline" type="submit">Approve</button>
                        </form>
                        <form action="{{ route('agent.disableAccount', $account->id) }}" method="POST">
                            <button class="text-red-600 dark:text-red-400 hover:underline" type="submit">Disable</a>
                        </form>
                        </td>
                    </tr>
                    @empty
                    <tr class="border-b dark:border-gray-700">
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                            No accounts found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>