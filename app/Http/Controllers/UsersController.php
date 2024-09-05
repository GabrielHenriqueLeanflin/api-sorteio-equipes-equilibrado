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

        return response()->json($lista)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin, Authorization');
    }

   public function store(Request $request)
   {
       $email = $request->input('email');
       $password = $request->input('username');

       if (DB::insert('INSERT INTO users (email, password) values (?, ?)', [$email, $password])){
           return "ok";
       } else {
           return "error";
       }

   }

   public function login(Request $request)
   {
       $email = $request->input('email');
       $password = $request->input('username');
   }
}
