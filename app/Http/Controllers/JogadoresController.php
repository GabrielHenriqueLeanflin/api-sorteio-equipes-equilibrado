<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jogadores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JogadoresController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['id' => 'required']);

        try {
            $jogadores = Jogadores::where('group_id', $request->get('id'))->get();

            return response()->json([
                'sucess' => true,
                'jogadores' => $jogadores
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'sucess' => false,
                'erro' => $th->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required',
            'name' => 'required',
            'level' => 'required',
            'position' => 'required'
        ]);

        try {

            DB::beginTransaction();
        Jogadores::create([
            'group_id' => $request->get('group_id'),
            'name' => $request->get('name'),
            'level' => $request->get('level'),
            'position' => $request->get('position')
        ]);

        DB::commit();
        return response()->json(['sucess' => true, 'message' => 'Jogador cadastrado com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['sucess' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request)
    {
        //
    }

    public function saveStatus(Request $request)
    {

        try {
            DB::beginTransaction();

            $listaJogadores = $request->all();

            foreach ($listaJogadores as $jogador) {
                $jogador['status'] = !$jogador['status'] ? 0 : 1;

                $userTabela = DB::table('jogadores')->where('id', $jogador['id'])->first();

                if ($userTabela->status === $jogador['status']) {
                    continue;
                } else {
                    DB::table('jogadores')
                        ->where('id', $jogador['id'])
                        ->update(['status' => $jogador['status']]);
                }
            }

            DB::commit();
            return response()->json(['sucess' => true, 'message' => 'Status do Jogador atualizado com sucesso!'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'sucess' => false,
                'erro' => $th->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();

            Jogadores::destroy($request['id']);

            DB::commit();
            return response()->json(['sucess' => true, 'message' => 'Jogador removido com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['sucess' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
