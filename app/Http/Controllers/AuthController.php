<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationMail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('signup');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
    
            $remember = $request->has('remember_me') ? true : false;

            $user = User::where('email', $request->email)->first();

            if ($user && $user->confirmation_token) {
                return back()->withErrors(['email' => 'Votre compte n\'a pas encore été confirmé. Vérifiez votre boîte de réception pour le lien de confirmation.']);
            }
    
            if (auth()->attempt($request->only('email', 'password'), $remember)) {
                session()->put('user', auth()->user());
                cookie()->queue('user', auth()->user(), 60);
                return redirect("/dashboard")->withSuccess("Bienvenue $user->first_name $user->last_name !");
            }

            return back()->withErrors(['email' => 'Les détails de connexion fournis sont invalides.'])->withInput();
        } else {
            return back()->with('status', 'Invalid method used to submit form');
        }
    }    

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->password != $request->confirm_password) {
                return back()->withErrors(['password' => 'Les mots de passes ne sont pas identiques.'])->withInput();
            }

            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'phone_number' => 'required',
                'address' => 'required',
                'city' => 'required',
                'country' => 'required',
                'postal_code' => 'required',
                'role' => 'required',
                'birthdate' => 'required',
                'password' => 'required|min:6',
            ]);

            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'birthdate' => $request->input('birthdate'),
                'phone_number' => $request->input('phone_number'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
                'postal_code' => $request->input('postal_code'),
                'role' => $request->input('role'),
                'biography' => 'Je suis nouveau sur GreenLabs 🚀',
                'profile_picture' => 'profile_pictures/profile-img.webp',
                'password' => Hash::make($request->input('password')),
            ]);

            $token = Str::random(60);
            $user->confirmation_token = $token;
            $user->save();

            Mail::to($user->email)->send(new ConfirmationMail($user));
    
            return redirect()->route('home')->with('success', 'Un e-mail de confirmation a été envoyé à votre adresse e-mail.');
        } else {
            return back()->with('status', 'Invalid method used to submit form');
        }
    }

    public function confirmAccount($token)
    {
        $user = User::where('confirmation_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Token de confirmation invalide.');
        }

        $user->confirmation_token = null;
        $user->save();

        auth()->login($user);

        return redirect()->route('home')->with('success', 'Votre compte a été confirmé avec succès. Bienvenue sur GreenLabs !');
    }

    public function logout()
    {
        auth()->logout();
        session()->forget('user');
        cookie()->queue(Cookie::forget('user'));
        return redirect()->route('home')->withErrors('Vous êtes déconnectés.');
    }
}
