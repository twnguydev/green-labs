<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function showDashboard()
    {
        $user = auth()->user();
        $products = $user->products;
        return view('dashboard', ['user' => $user, 'products' => $products]);
    }

    public function showProfile($firstname, $lastname)
    {
        $userLogged = auth()->user();
        $firstname = ucfirst($firstname);
        $lastname = ucfirst($lastname);

        $user = User::where('first_name', $firstname)
            ->where('last_name', $lastname)
            ->first();

        $products = $user->products;

        return view('profile', [
            'access' => $userLogged->first_name === $firstname && $userLogged->last_name === $lastname,
            'user' => $user,
            'products' => $products,
        ]);
    }

    public function updateProfile(Request $request, $firstname, $lastname)
    {
        if ($request->isMethod('post')) {
            $userLogged = auth()->user();
            $firstname = ucfirst($firstname);
            $lastname = ucfirst($lastname);

            if ($userLogged->first_name === $firstname && $userLogged->last_name === $lastname) {
                $request->validate([
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email',
                    'phone_number' => 'required',
                    'address' => 'required',
                    'city' => 'required',
                    'country' => 'required',
                    'postal_code' => 'required',
                    'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                $user = User::where('first_name', $firstname)
                    ->where('last_name', $lastname)
                    ->firstOrFail();

                $user->update([
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'phone_number' => $request->input('phone_number'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'country' => $request->input('country'),
                    'postal_code' => $request->input('postal_code'),
                ]);

                if ($request->hasFile('profile_picture')) {
                    $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
                    $user->save();
                }

                Auth::login($user);

                if ($userLogged->first_name !== $user->first_name || $userLogged->last_name !== $user->last_name) {
                    return redirect()->route('profile', [
                        'firstname' => strtolower($user->first_name),
                        'lastname' => strtolower($user->last_name),
                    ])->withSuccess('Profil mis à jour');
                }
            }
    
            return back()->with('status', 'Vous n\'êtes pas autorisé à mettre à jour ce profil');
        } else {
            return back()->with('status', 'Méthode invalide utilisée pour soumettre le formulaire');
        }
    }

    public function updateBiography(Request $request, $firstname, $lastname)
    {
        if ($request->isMethod('post')) {
            $userLogged = auth()->user();
            $firstname = ucfirst($firstname);
            $lastname = ucfirst($lastname);

            if ($userLogged->first_name === $firstname && $userLogged->last_name === $lastname) {
                $request->validate([
                    'biography' => 'required',
                ]);

                $user = User::where('first_name', $firstname)
                    ->where('last_name', $lastname)
                    ->firstOrFail();

                $user->biography = $request->input('biography');
                $user->save();
    
                return redirect()->route('profile', [
                    'firstname' => strtolower($user->first_name),
                    'lastname' => strtolower($user->last_name),
                ])->withSuccess('Biographie mise à jour');
            }
    
            return back()->with('status', 'Vous n\'êtes pas autorisé à mettre à jour cette biographie');
        } else {
            return back()->with('status', 'Méthode invalide utilisée pour soumettre le formulaire');
        }
    }
}
