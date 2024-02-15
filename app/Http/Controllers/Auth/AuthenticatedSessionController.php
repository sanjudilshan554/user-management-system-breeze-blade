<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    protected $user;

    public function __construct(){
        $this->user = new User();
    }


    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {

        // $request->authenticate();

        //         $request->session()->regenerate();

        //         return redirect()->intended(RouteServiceProvider::HOME);
    
        $user = $this->user->where('email', $request->email)->first();

        if($user){
            $user_type= $user->user_type;
            $status= $user->status;

            if($user_type == 'admin' || $user_type == 'superadmin' || $status == 1){
                $request->authenticate();

                $request->session()->regenerate();

                return redirect()->intended(RouteServiceProvider::HOME);
            }else{
                return view('welcome');
            }
        }else{
            return redirect()->route('login')->with('error', 'Invalid credentials.');;
        }
        
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
