<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BankAgentController extends Controller
{
    /**
     * Display the dashboard for the banking agent with relevant data.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Retrieve data needed for the dashboard, such as pending accounts and recent transactions
        $pendingAccounts = Account::where('status', 'pending')->get();
        $recentTransactions = Transaction::orderBy('created_at', 'desc')->take(10)->get();

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

        // Update the account status
        $account->status = 'approved';
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
        ]);

        // Execute the transaction logic
        DB::transaction(function () use ($request) {
            $account = Account::findOrFail($request->account_id);

            // Check if it's a withdrawal and if there's enough balance
            if ($request->type === 'withdrawal' && $account->balance < $request->amount) {
                abort(403, 'Insufficient balance for this withdrawal.');
            }

            // Update the account balance
            $account->balance += ($request->type === 'deposit') ? $request->amount : -$request->amount;
            $account->save();

            // Record the transaction
            Transaction::create([
                'account_id' => $account->id,
                'type' => $request->type,
                'amount' => ($request->type === 'deposit') ? $request->amount : -$request->amount,
                'created_at' => now(),
                'description' => $request->type . ' by bank agent',
            ]);
        });

        return redirect()->route('agent.dashboard')->with('success', 'Transaction executed successfully.');
    }

    public function showTransactionForm()
    {
        $accounts = Account::all();

        return view('agent.transaction_form', compact('accounts'));
    }

    public function allTransactions()
    {
        $transactions = Transaction::with('account')->orderBy('created_at', 'desc')->get();

        return view('agent.all_transactions', compact('transactions'));
    }

    public function disableAccount($accountId)
    {
        $account = Account::findOrFail($accountId);

        // Disable the account
        $account->status = 'disabled';
        $account->save();

        // Redirect to a route or view with a success message
        return back()->with('success', 'Account has been disabled.');
    }

    public function allAccounts()
    {
        // Retrieve all accounts
        $accounts = Account::with('user')->orderBy('user_id', 'desc')->get();

        return view('agent.all_accounts', compact('accounts'));
    }
}