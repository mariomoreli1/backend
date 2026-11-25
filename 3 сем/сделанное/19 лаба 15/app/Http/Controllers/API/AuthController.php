<?php
// ЛР15. Копия AuthController в папке API (namespace App\Http\Controllers\API).
// Вместо redirect/view — response()->json; вход отдаёт токен, дальше он передаётся в заголовке Authorization: Bearer.

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // регистрация
    public function registration(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = Role::where('name', 'reader')->first()->id;
        $user->save();

        return response()->json($user, 201);
    }

    // вход, в ответ отдаём токен
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('myAppToken')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'Неверный email или пароль'], 401);
    }

    // выход, удаляем токены
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Вы вышли']);
    }
}
