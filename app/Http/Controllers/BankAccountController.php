<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{
    /**
     * Show the form for creating a new account.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Store a newly created account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'currency' => 'required|in:LBP,USD,EUR',
        ]);

        // Create the account
        $account = new Account([
            'user_id' => Auth::id(),
            'account_number' => $this->generateAccountNumber(),
            'currency' => $request->currency,
            'balance' => $request->balance, 
            'status' => 'pending',
        ]);

        $account->save();

        // Redirect to a route or view with a success message
        return redirect()->route('dashboard')->with('success', 'Account created successfully and pending approval.');
    }

    /**
     * Display the specified account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = Account::findOrFail($id);

        // Authorization check to ensure the authenticated user owns the account
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        // Assuming you have a view named 'account.details' to display account details
        return view('account.details', compact('account'));
    }

    /**
     * Show the form for the banking agent to approve account creation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approval($id)
    {
        $account = Account::findOrFail($id);

        // Assuming you have a view named 'account.approval' for the approval process
        return view('account.approval', compact('account'));
    }

    /**
     * Update the specified account's approval status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateApproval(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        // Validate the request data
        $request->validate([
            'status' => 'required|in:approved,disapproved',
        ]);

        // Update the account status
        $account->status = $request->status;
        $account->save();

        // Redirect to a route or view with a success message
        return redirect()->route('dashboard')->with('success', 'Account approval status updated.');
    }

    /**
     * Generate a unique account number.
     *
     * @return string
     */
    private function generateAccountNumber()
    {
        return str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
    }
}