<?php
// ЛР6. registration: проверка данных, email уникальный, пароль хешируется через Hash::make, потом редирект на вход.
// authenticate: Auth::attempt проверяет email и пароль, выдаю токен через createToken, редирект на главную.
// logout: удаляю токены, выхожу, сбрасываю сессию и обновляю csrf-токен.

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // форма регистрации
    public function create()
    {
        return view('auth.signin');
    }

    // сохраняем нового пользователя
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
        $user->save();

        return redirect('/login');
    }

    // форма входа
    public function login()
    {
        return view('auth.login');
    }

    // вход
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // выдаём пользователю токен
            $token = $request->user()->createToken('myAppToken')->plainTextToken;
            $request->session()->put('token', $token);

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль',
        ])->onlyInput('email');
    }

    // выход
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
