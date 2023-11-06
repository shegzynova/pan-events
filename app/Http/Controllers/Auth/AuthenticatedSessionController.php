<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Event;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
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
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if ($request->user()->hasRole('admin')) {
            return redirect()->intended(RouteServiceProvider::ADMINHOME);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
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

    public function membership_login(Request $request)
    {
        if($request->isMethod('GET')){
            return view('auth.m-login');
        }

        //Call Membership API
        try {
            DB::beginTransaction();
            $payload = [
                'email' => $request->email,
                'password' => $request->password
            ];
            $endPoint = 'https://portal.pan-ng.org/api/login';
            $response = Http::post($endPoint, $payload);
            if(!$response){
                return redirect()->back()->with('error', 'Unable to Login Now');
            }
            $response =  $response->body();
//            $response = file_get_contents('data/m-successful.sql');
            $response = gettype($response) == 'string' ? json_decode($response) : $response;

            if($response->status != 'success'){
                return redirect()->back()->with('error', $response->message);
            }

            $user = User::whereEmail($request->email)->first();

            if(!is_null($user)){
                if (! Auth::login($user, true)) {

                    throw ValidationException::withMessages([
                        'email' => trans('auth.failed'),
                    ]);
                }

                return redirect()->intended();
            }

            $user_type = optional(optional(optional($response)->data)->paediatric_data)->membership_account;

            $userData = [
                'first_name' => optional(optional($response)->data)->first_name,
                'last_name' => optional(optional($response)->data)->last_name,
                'username' => optional(optional($response)->data)->username,
                'phone' => optional(optional($response)->data)->phone,
                'user_type' => !is_null($user_type) ? $user_type.'_member' : 'ordinary_member',
                'email' => optional(optional($response)->data)->email,
                'email_verified_at' => now(),
                'password' => Hash::make($request->password)
            ];

            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            DB::commit();

            Auth::login($user);

            $mostRecentEvent = Event::latest()->first();
            if ($mostRecentEvent) {
                return redirect(route('user.events.step_one_get', $mostRecentEvent));
            }

            return redirect()->intended();

        } catch (\Exception $e) {

            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
}
