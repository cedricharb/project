<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Show the form for creating a new transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Assuming you have a view named 'transaction.transfer' with the fund transfer form
        return view('transaction.transfer');
    }

    /**
     * Store a newly created transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'from_account_id' => 'required|exists:accounts,id',
            'to_account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            // Add other validation rules as needed
        ]);

        // Perform the fund transfer logic (simplified for this example)
        DB::transaction(function () use ($request) {
            $fromAccount = Account::findOrFail($request->from_account_id);
            $toAccount = Account::findOrFail($request->to_account_id);

            // Authorization check to ensure the authenticated user owns the from_account
            if ($fromAccount->user_id !== Auth::id()) {
                abort(403);
            }

            // Check sufficient balance in the from_account
            if ($fromAccount->balance < $request->amount) {
                abort(400, 'Insufficient balance for the transfer.');
            }

            if ($fromAccount->currency != $toAccount->currency) {
                abort(400, 'Cannot transfer between accounts with different currencies.');
            }

            // Deduct the amount from the from_account
            $fromAccount->balance -= $request->amount;
            $fromAccount->save();

            // Add the amount to the to_account
            $toAccount->balance += $request->amount;
            $toAccount->save();

            // Record the transaction
            Transaction::create([
                'account_id' => $fromAccount->id,
                'type' => 'transfer',
                'amount' => -$request->amount, // Negative because it's an outgoing transfer
                'created_at' => now(),
                'description' => 'Transfer to account ' . $toAccount->id,
            ]);

            Transaction::create([
                'account_id' => $toAccount->id,
                'type' => 'transfer',
                'amount' => $request->amount, // Positive because it's an incoming transfer
                'created_at' => now(),
                'description' => 'Transfer from account ' . $fromAccount->id,
            ]);
        });

        // Redirect to a route or view with a success message
        return redirect()->route('transaction.index')->with('success', 'Fund transfer completed successfully.');
    }

    /**
     * Display the transaction history for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all transactions for the authenticated user's accounts
        $transactions = Transaction::whereHas('account', function ($query) {
            $query->where('user_id', Auth::id());
        })->orderBy('created_at', 'desc')->get();

        // Assuming you have a view named 'transaction.history' to display transaction history
        return view('transaction.history', compact('transactions'));
    }

    // Other methods related to transaction management can be added here
}