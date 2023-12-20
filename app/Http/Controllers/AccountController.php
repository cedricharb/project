<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Show the form for creating a new account.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Assuming you have a view named 'account.create' with the account creation form
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
            // Add other validation rules as needed
        ]);

        // Create the account
        $account = new Account([
            'user_id' => Auth::id(),
            'account_number' => $this->generateAccountNumber(), // Implement this method to generate a unique account number
            'currency' => $request->currency,
            'balance' => 0, // Assuming new accounts start with a balance of 0
            'status' => 'pending', // Assuming new accounts have a status of 'pending' until approved
        ]);

        $account->save();

        // Redirect to a route or view with a success message
        return redirect()->route('account.index')->with('success', 'Account created successfully and pending approval.');
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

        // Authorization check to ensure the authenticated user is a banking agent
        // This should be handled by a middleware or a policy
        $this->authorize('approve', $account);

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

        // Authorization check to ensure the authenticated user is a banking agent
        // This should be handled by a middleware or a policy
        $this->authorize('approve', $account);

        // Validate the request data
        $request->validate([
            'status' => 'required|in:approved,disapproved',
        ]);

        // Update the account status
        $account->status = $request->status;
        if ($request->status == 'approved') {
            $account->approved_by_agent_id = Auth::id();
        }
        $account->save();

        // Redirect to a route or view with a success message
        return redirect()->route('agent.dashboard')->with('success', 'Account approval status updated.');
    }

    // Other methods related to account management can be added here

    /**
     * Generate a unique account number.
     *
     * @return string
     */
    private function generateAccountNumber()
    {
        // Implement logic to generate a unique account number
        // This is just a placeholder function
        return str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
    }
}