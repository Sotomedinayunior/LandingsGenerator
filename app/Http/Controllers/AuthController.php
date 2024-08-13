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
        // Validación de los campos de la solicitud
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed',
            'phone' => 'string|max:25',
            'theme' => 'string|max:100',
            'avatar'=>'nullable|string|max:600',
            'role' => 'required|string|in:admin,user', // Asegúrate de que el rol esté presente y sea válido
        ]);

        // Utiliza una imagen de avatar predeterminada si no se proporciona una
        $avatar = 'https://api.multiavatar.com/Binx Bond.png'; // Cambia esta URL por la de la imagen predeterminada

        // Crea el usuario con los datos proporcionados
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'phone' => $fields['phone'],
            'avatar' => $avatar,
            'theme' => $fields['theme'],
            'role' => $fields['role'], // Incluye el rol en el modelo User si es necesario
        ]);

        // Asignar el rol al usuario
        $user->assignRole($fields['role']);

        // Crear un token para el usuario
        $token = $user->createToken($request->name , ['*'] ,now()->addMinutes(30) );

        // Retornar la respuesta con el usuario y el token
        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
            'expires_in'=> 30 * 60
        ]);
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
        $errors['email'] = ['The email is not registered.'];
    } else {
        // Verificar la contraseña
        if (!Hash::check($request->password, $user->password)) {
            $errors['password'] = ['The password is incorrect.'];
        }
    }

    // Si hay errores, devolver una respuesta con los errores
    if (!empty($errors)) {
        return response()->json([
            'errors' => $errors
        ], 422);
    }

    // Si no hay errores, generar el token y devolver la respuesta de éxito
    $token = $user->createToken($user->name, ['*'], now()->addMinutes(30));

    return response()->json([
        'user' => $user,
        'token' => $token->plainTextToken,
        'expiration' => now()->addMinutes(30)->toDateTimeString()
    ]);
}



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'You are logged out.' 
        ];
    }
}