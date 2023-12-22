<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Check if the authenticated user is a banking agent or a client
        if (Auth::user()->is_agent) {
            // If the user is a banking agent, show the banking agent dashboard
            return $this->agentDashboard();
        } else {
            // If the user is a client, show the client dashboard
            return $this->clientDashboard();
        }
    }

    /**
     * Show the client dashboard with relevant data.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function clientDashboard()
    {
        // Retrieve data needed for the client dashboard
        $accounts = Account::where('user_id', Auth::id())->get();
        $recentTransactions = Transaction::whereHas('account', function ($query) {
            $query->where('user_id', Auth::id());
        })->orderBy('created_at', 'desc')->take(10)->get();

        // Assuming you have a view named 'client.dashboard' for the client dashboard
        return view('client.dashboard', compact('accounts', 'recentTransactions'));
    }
}
