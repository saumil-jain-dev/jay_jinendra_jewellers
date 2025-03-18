<?php

namespace App\Http\Controllers;

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
        $this->data['userCount'] = $userCount;
        $this->data['guarantorsCount'] = $guarantorsCount;
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
