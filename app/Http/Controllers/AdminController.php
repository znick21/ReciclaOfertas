<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Si estás usando el modelo User para la autenticación

class AdminController extends Controller
{
    // Vista de login administrador
    public function loginForm()
    {
        return view('auth.AdminLogin'); // Vista de login administrador
    }

    // Vista del Dashboard del administrador
    public function adminDashboard()
{
    // Obtener todos los usuarios
    $users = User::all(); // Obtén todos los usuarios de la base de datos

    // Pasar los usuarios a la vista
    return view('admin.DashboardAdmin', compact('users')); // Asegúrate de que el nombre de la vista sea correcto
}

    // Método para manejar el submit del login
    public function loginSubmit(Request $request)
    {
        // Validar los campos del formulario de login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Obtener las credenciales del formulario
        $credentials = $request->only('email', 'password');

        // Intentar autenticar al administrador
        if (Auth::attempt($credentials)) {
            // Si la autenticación es exitosa, redirigir al Dashboard
            return redirect()->route('admin.dashboard');
        } else {
            // Si la autenticación falla, redirigir de nuevo al formulario con un mensaje de error
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Credenciales incorrectas. Intenta de nuevo.']);
        }
    }
    // Método para mostrar el formulario de edición de un usuario
    public function editUser($id)
    {
    // Buscar el usuario por ID
    $user = User::findOrFail($id);

    // Pasar los datos del usuario a la vista de edición
    return view('admin.editUser', compact('user')); // Asegúrate de tener la vista 'editUser'
    }

    // Método para actualizar los datos de un usuario
    public function updateUser(Request $request, $id)
    {
    // Validar los datos del formulario
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id, // Evita el conflicto de email con el usuario actual
    ]);

    // Buscar al usuario por ID
    $user = User::findOrFail($id);

    // Actualizar los datos del usuario
    $user->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
    ]);

    // Redirigir a la vista de dashboard con un mensaje de éxito
    return redirect()->route('admin.dashboard')->with('success', 'Usuario actualizado correctamente.');
    }
    // Método para eliminar un usuario
    public function deleteUser($id)
    {
    // Buscar al usuario por ID
    $user = User::findOrFail($id);

    // Eliminar el usuario
    $user->delete();

    // Redirigir a la vista de dashboard con un mensaje de éxito
    return redirect()->route('admin.dashboard')->with('success', 'Usuario eliminado correctamente.');
    }


}
