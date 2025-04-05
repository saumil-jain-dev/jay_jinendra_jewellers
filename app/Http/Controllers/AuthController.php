<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillingHistory;
use App\Models\Guarantor;
use App\Models\Party;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $data;
    //
        /**
     * Handle the login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginPost(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            session()->flash('message', 'Logged in successfully!');
            session()->flash('alert-type', 'success');
            return redirect()->route('dashboard');
        }
        session()->flash('message', 'The provided credentials do not match our records.');
        session()->flash('alert-type', 'error');
        return redirect()->back();
    }

    public function dashboard(){
        $this->data['pageTitle']  = "Jjj | Dashboard";
         // You can pass data to the dashboard view here
        $userCount = Party::count();
        $guarantorsCount = Guarantor::count();
        $latestUsers = Party::latest()->take(5)->get();
        $billingTotal = Bill::whereNull('deleted_at')->sum('final_amount');
        $cashReceptTotal = Bill::whereNull('deleted_at')->sum('cash_amount') + BillingHistory::whereNull('deleted_at')->where('payment_type','cash')->sum('amount');
        $onlineReceptTotal = Bill::whereNull('deleted_at')->sum('online_amount') + BillingHistory::whereNull('deleted_at')->where('payment_type','online')->sum('amount');
        $remainingTotal = Bill::whereNull('deleted_at')->sum('total_due_amount');
        $this->data['userCount'] = $userCount;
        $this->data['guarantorsCount'] = $guarantorsCount;
        $this->data['billingTotal'] = $billingTotal;
        $this->data['cashReceptTotal'] = $cashReceptTotal;
        $this->data['onlineReceptTotal'] = $onlineReceptTotal;
        $this->data['remainingTotal'] = $remainingTotal;
         return view('dashboard', $this->data);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->flash('message', 'Logged out successfully!');
        session()->flash('alert-type', 'success');
        return redirect('/');
    }
}
