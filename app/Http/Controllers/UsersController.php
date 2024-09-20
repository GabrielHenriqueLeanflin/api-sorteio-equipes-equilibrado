<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            DB::beginTransaction();

        $user = Users::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Criptografa a senha
        ]);

        // Autentica o usuário automaticamente após o cadastro
        Auth::login($user);

        DB::commit();
        return response()->json(['success' => true, 'message' => 'Cadastro realizado com sucesso!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
        // Verifica as credenciais e autentica o usuário
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'sucess' => false,
                'message' => 'Credenciais incorretas.'
            ], 400);
        }

        return response()->json([
            'sucess' => true,
            'message' => 'Login realizado com sucesso!',
            'user' => Auth::user() // Retorna o usuário autenticado
        ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'sucess' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
