<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class AuthController extends Controller
{


    public function register(Request $request)
    {
        try {
            // Validar los datos
            $fields = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:3',
                'phone' => 'nullable|string|max:25',
          
                'role' => 'required|string|in:admin,user',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            // Manejar la carga de archivo del avatar
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('users', 'public'); // Almacena el archivo en public/users
                $avatar = asset('storage/' . $avatarPath); // Genera la URL pública
            } else {
                // Generar un avatar único usando Multiavatar si no se proporciona una imagen
                $avatar = 'https://api.multiavatar.com/' . urlencode($fields['name']) . '.png';
            }

            // Validar la URL del avatar (opcional)
            if (!filter_var($avatar, FILTER_VALIDATE_URL)) {
                throw new \Exception('URL del avatar no válida.');
            }

            // Crear el usuario con los datos proporcionados
            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password']),
                'phone' => $fields['phone'],
                'avatar' => $avatar,
           
                'role' => $fields['role'],
            ]);

            // Asignar el rol al usuario
            $user->assignRole($fields['role']);

            // Crear un token para el usuario
            $token = $user->createToken($request->name, ['*'], now()->addMinutes(60));

            // Retornar la respuesta con el usuario y el token
            return response()->json([
                'user' => $user,
                'token' => $token->plainTextToken,
                'expires_in' => 60
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejar errores de validación
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Manejar otros errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function login(Request $request)
    {
        // Validar los datos del request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Buscar el usuario por email
        $user = User::where('email', $request->email)->first();

        // Preparar el array de errores
        $errors = [];

        // Verificar si el usuario existe
        if (!$user) {
            $errors['email'] = ['El email no esta registrado.'];
        } else {
            // Verificar la contraseña
            if (!Hash::check($request->password, $user->password)) {
                $errors['password'] = ['La contraseña es incorrecta.'];
            }
        }

        // Si hay errores, devolver una respuesta con los errores
        if (!empty($errors)) {
            return response()->json([
                'errors' => $errors
            ], 422);
        }

        // Si no hay errores, generar el token y devolver la respuesta de éxito
        $token = $user->createToken($user->name, ['*'], now()->addMinutes(60));

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
            'expiration' => now()->addMinutes(60)->toDateTimeString()
        ]);
    }
    public function update(Request $request)
    {
        try {
            // Validar los datos
            $fields = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
                'phone' => 'required|string|max:25',
                'password' => 'required|string|confirmed|min:3',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Avatar opcional
            ]);

            // Obtener el usuario autenticado
            $user = $request->user();

            // Manejar la carga de archivo del avatar
            if ($request->hasFile('avatar')) {
                // Eliminar el avatar antiguo si no es el predeterminado
                if ($user->avatar && filter_var($user->avatar, FILTER_VALIDATE_URL) === false) {
                    $oldAvatarPath = str_replace(asset('storage/') . '/', '', $user->avatar);
                    Storage::disk('public')->delete($oldAvatarPath);
                }

                // Almacenar el nuevo avatar
                $avatarPath = $request->file('avatar')->store('users', 'public');
                $avatar = asset('storage/' . $avatarPath); // Generar la URL pública
            } else {
                // Mantener el avatar actual si no se proporciona uno nuevo
                $avatar = $user->avatar;
            }

            // Actualizar los datos del usuario
            $user->update([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password']),
                'phone' => $fields['phone'],
                'avatar' => $avatar,
            ]);

            return response()->json([
                'message' => 'Información actualizada con éxito',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un problema al actualizar la información.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }




    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'You are logged out.'
        ];
    }
}
