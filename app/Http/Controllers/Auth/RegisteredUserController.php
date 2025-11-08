<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $registrationField = $request->input('register_with', 'email');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        $userData = [
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ];

        if ($registrationField === 'email') {
            $rules['email'] = ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class];
            $userData['email'] = $request->email;
            $userData['phone_number'] = null;
        } else {
            $rules['phone_number'] = ['required', 'phone:INTERNATIONAL', 'unique:'.User::class];
            $userData['phone_number'] = $request->phone_number;
            $userData['email'] = null;
        }

        $request->validate($rules);

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
