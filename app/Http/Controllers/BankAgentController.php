<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BankAgentController extends Controller
{
    /**
     * Display the dashboard for the banking agent with relevant data.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Assuming you have a view named 'agent.dashboard' for the banking agent dashboard
        // Retrieve data needed for the dashboard, such as pending accounts and recent transactions
        $pendingAccounts = Account::where('status', 'pending')->get();
        $recentTransactions = Transaction::orderBy('transaction_date', 'desc')->take(10)->get();

        return view('agent.dashboard', compact('pendingAccounts', 'recentTransactions'));
    }

    /**
     * Approve or disapprove a client's account creation request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $accountId
     * @return \Illuminate\Http\Response
     */
    public function approveAccount(Request $request, $accountId)
    {
        // Validate the request data
        $request->validate([
            'status' => 'required|in:approved,disapproved',
        ]);

        $account = Account::findOrFail($accountId);

        // Authorization check to ensure the authenticated user is a banking agent
        $this->authorize('approveAccount', $account);

        // Update the account status
        $account->status = $request->status;
        if ($request->status == 'approved') {
            $account->approved_by_agent_id = Auth::id();
        }
        $account->save();

        // Redirect to a route or view with a success message
        return redirect()->route('agent.dashboard')->with('success', 'Account status updated successfully.');
    }

    /**
     * Display a listing of clients.
     *
     * @return \Illuminate\Http\Response
     */
    public function clients()
    {
        // Retrieve all clients
        $clients = User::where('is_agent', false)->get(); // Assuming 'is_agent' is a boolean attribute on the User model

        // Assuming you have a view named 'agent.clients' to list clients
        return view('agent.clients', compact('clients'));
    }

    /**
     * Enable or disable access for a client to their account.
     *
     * @param  int  $userId
     * @param  bool  $status
     * @return \Illuminate\Http\Response
     */
    public function toggleAccess($userId, $status)
    {
        $user = User::findOrFail($userId);

        // Authorization check to ensure the authenticated user is a banking agent
        $this->authorize('toggleAccess', $user);

        // Toggle the access status
        $user->access_enabled = $status;
        $user->save();

        // Redirect to a route or view with a success message
        return redirect()->route('agent.clients')->with('success', 'Client access has been ' . ($status ? 'enabled' : 'disabled') . '.');
    }

    /**
     * Execute a deposit or withdrawal transaction on behalf of a client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function executeTransaction(Request $request)
    {
        // Validate the request data
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:deposit,withdrawal',
            'amount' => 'required|numeric|min:0.01',
            // Add other validation rules as needed
        ]);

        // Execute the transaction logic
        // This should be similar to the logic in the TransactionController@store method
        // Make sure to check if the banking agent is authorized to perform this action

        // Redirect to a route or view with a success message
        return redirect()->route('agent.dashboard')->with('success', 'Transaction executed successfully.');
    }

    // Other methods related to banking agent operations can be added here

    // Add methods for viewing and managing client transactions, etc.
}