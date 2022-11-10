<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredUserRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\Auth\RegisteredUserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $plan = session()->get('plan') ?? null;
        if(!isset($plan)) {
            return redirect()->route('site.home');
        }

        return view('auth.register', ['plan' => $plan]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisteredUserRequest $request)
    {
        $registeredRep = new RegisteredUserRepository();

        $user = $registeredRep->register($request->all());

        event(new Registered($user));

        Auth::login($user);

        session()->forget('plan');

        return redirect(RouteServiceProvider::HOME);
    }
}
