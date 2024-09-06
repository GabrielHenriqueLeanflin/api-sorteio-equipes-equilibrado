<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $lista = [
            'teste',
            'teste',
            'teste',
            'teste',
        ];

        return ($lista);
    }

   public function store(Request $request)
   {


       $name = $request['name'];
       $email = $request['email'];
       $password = $request['password'];
       $confirm_password = $request['confirm_password'];

       if($password == $confirm_password){
           // Retorna uma mensagem de sucesso com status 200 (OK)
           return response()->json([
               'status' => 'success',
               'message' => 'Usuário cadastrado com sucesso!'
           ], 200);
       } else {
           // Retorna uma mensagem de erro com status 400 (Bad Request)
           return response()->json([
               'status' => 'error',
               'message' => 'As senhas não coincidem.'
           ], 400);
       }


       /*       if (DB::insert('INSERT INTO users (email, password) values (?, ?)', [$email, $password])){
                  return "ok";
              } else {
                  return "error";
              }*/

   }

   public function login(Request $request)
   {
       $email = $request->input('email');
       $password = $request->input('username');
   }
}
