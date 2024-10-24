<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;



class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Valida l'input, inclusa l'immagine di profilo
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Limita i formati e la dimensione dell'immagine
        ]);

        // Se l'utente ha caricato un'immagine
        if ($request->hasFile('profile_image')) {
            // Cancella l'immagine precedente se esiste
            if ($user->profile_image) {
                Storage::delete('public/' . $user->profile_image);
            }

            // Salva la nuova immagine nella cartella 'profile_images' nello storage pubblico
            $path = $request->file('profile_image')->store('profile_images', 'public');

            // Aggiorna il campo profile_image dell'utente con il nuovo percorso
            $user->profile_image = $path;
        }

        // Aggiorna nome ed email
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
