<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Avaliacao;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

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

    public function show(string $id): View
    {
        $user = User::with('fotoPerfil')->findOrFail($id);

        $reviews = Avaliacao::with(['filme.imagens', 'usuario'])
            ->where('usuario_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('profile.show', compact('user', 'reviews'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        if ($request->hasFile('foto_perfil')) {
            $caminho = $request->file('foto_perfil')->store('profiles', 'public');

            if ($request->user()->fotoPerfil) {
                Storage::disk('public')->delete($request->user()->fotoPerfil->caminho);
                $request->user()->fotoPerfil()->delete();
            }

            DB::table('foto_perfil')->insert([
                'usuario_id' => $request->user()->id,
                'nome' => $request->user()->name,
                'caminho' => $caminho,
            ]);
        }

        return Redirect::route('profile.edit')->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Delete the user's account.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
