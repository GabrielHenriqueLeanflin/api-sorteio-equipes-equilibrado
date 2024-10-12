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

    public function atualizarStatus(Request $request)
    {
        try {
            DB::beginTransaction();

            $jogador = $request->all();

            if ($jogador['status'] == 1) {
                DB::table('jogadores')
                    ->where('id', $jogador['id'])
                    ->update(['status' => 0]);
            } else {
                DB::table('jogadores')
                    ->where('id', $jogador['id'])
                    ->update(['status' => 1]);
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

            $id = $request->all();

            Jogadores::destroy($id);

            DB::commit();
            return response()->json(['sucess' => true, 'message' => 'Jogador removido com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['sucess' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
