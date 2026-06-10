<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario para editar el perfil del usuario autenticado.
     *
     * Retorna la vista 'profile.edit' pasando la instancia del usuario obtenida desde la
     * solicitud HTTP.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP.
     * @return \Illuminate\View\View Vista del formulario de perfil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualiza la información básica de perfil del usuario autenticado.
     *
     * Llena el modelo del usuario con los datos validados del request de actualización de perfil,
     * comprueba si el correo electrónico ha cambiado para invalidar la fecha de verificación
     * anterior, y guarda los cambios en la base de datos. Redirecciona con un estatus.
     *
     * @param \App\Http\Requests\ProfileUpdateRequest $request Request validado para la actualización de perfil.
     * @return \Illuminate\Http\RedirectResponse Redirección a la edición de perfil con estatus de éxito.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Elimina permanentemente la cuenta del usuario autenticado en el sistema.
     *
     * Valida que la contraseña suministrada sea la actual. Cierra la sesión del usuario, realiza
     * la eliminación física del registro del usuario de la base de datos, invalida la sesión de la
     * petición HTTP actual y regenera el token CSRF para seguridad. Redirecciona a la página de inicio.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con la contraseña de confirmación.
     * @return \Illuminate\Http\RedirectResponse Redirección a la raíz pública del sitio.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
