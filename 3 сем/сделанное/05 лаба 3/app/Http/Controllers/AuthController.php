<?php
# Создал контроллер через make:controller.
 #create показывает форму. 
 #registration проверяет данные через validate и возвращает их в json.
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.signin');
    }

    public function registration(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
