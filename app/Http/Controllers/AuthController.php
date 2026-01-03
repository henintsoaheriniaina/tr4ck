<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('pages.auth.login');
    }
    public function registerPage()
    {
        return view('pages.auth.register');
    }
    public function register(RegisterFormRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('avatars', 'public');
            $data['image_path'] = $path;
            $data['image_url'] = Storage::url($path);
        }
        $user = User::create($data);
        Auth::login($user);
        return redirect()->route('index')->with('success', 'Compte créé avec succès!');
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ], [
            'email.required' => 'Le champ email est obligatoire.',
            'email.string' => 'Le champ email doit être une chaîne de caractères.',
            'email.email' => 'Le champ email doit être une adresse email valide.',
            'password.required' => 'Le champ mot de passe est obligatoire.',
            'password.string' => 'Le champ mot de passe doit être une chaîne de caractères.',
        ]);
        $remember = $request->filled("remember");
        if (Auth::attempt($validated, $remember)) {
            return redirect()->intended(route("index"));
        }
        return back()->withErrors([
            'password' => "Email ou mot de passe incorrect.",
            'email' => "Email ou mot de passe incorrect.",
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("login");
    }

    public function showProfile(User $user)
    {
        return view('pages.users.profile', [
            "user" => $user
        ]);
    }




    public function updateProfileImage(Request $request)
    {
        $validated = $request->validate([
            "image_url" => "required|image|file|mimes:png,jpg,jpeg,webp|max:2048",
        ], [
            "image_url.required" => "L'image est requise.",
            "image_url.image" => "Le fichier doit être une image.",
            "image_url.file" => "Le fichier doit être valide.",
            "image_url.mimes" => "L'image doit être au format PNG, JPG, JPEG ou WEBP.",
            "image_url.max" => "L'image ne doit pas dépasser 2 Mo.",
        ]);
        return redirect()->route('profile.show', Auth::user())
            ->with('success', 'Votre photo de profil a été mise à jour avec succès.');
    }
    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $fields = $request->validate(
            [
                'old_password' => 'required|string',
                'password' => 'required|string|confirmed',
            ],
            [
                'old_password.required' => 'L\'ancien mot de passe est obligatoire.',
                'password.required' => 'Le nouveau mot de passe est obligatoire.',
                'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            ]
        );

        if (!password_verify($fields['old_password'], $user->password)) {
            return back()->withErrors(['old_password' => 'L\'ancien mot de passe est incorrect.']);
        }

        $user->password = bcrypt($fields['password']);
        $user->save();

        return redirect()->route('profile.show', $user)
            ->with('success', 'Votre mot de passe a été mis à jour avec succès.');
    }
}
