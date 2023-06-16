<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CadastroIngredientes;
use App\Models\CadastroReceita;

class CadastroController extends Controller{
    
    public function cadastroReceitaView(){
        return view('cadastroReceita');
    }

    public function cadastrarReceita(Request $request) {
        $receita = $request->input('receita');

        $novaReceita = new CadastroReceita();
        $novaReceita->receita = $receita;

        $novaReceita->save();
    }

    public function listarReceitas(){
        $receitas = CadastroReceita::all();
        return $receitas;
    }

    public function excluirReceita($id){
        $receita = CadastroReceita::find($id);
        $deleteReceita = $receita->delete();
        return $deleteReceita;

    }

    public function editarReceita(Request $request, $id){
        $novoNome = $request->input('nome');
        $receita = CadastroReceita::find($id);
        $receita->receita = $novoNome;
        $receita->save();
    }
    

    public function cadastroIngredienteView($id){
        return view('cadastroIngrediente', ['id' => $id]);
    }

    public function buscaReceita($id){
        $receita = CadastroReceita::find($id);
        return response()->json(['nome' => $receita->receita]);
    }

    public function cadastrarIngredientes(Request $request, $id){

        $ingredientes = [
            'receita_id' => $id,
            'ordem' => $request->ordem,
            'codigo' => $request->codigo,
            'descricao' => $request->descricao,
            'previstoKG' => $request->previstoKG,
        ];
    
        CadastroIngredientes::create($ingredientes);
    }
    
    public function listarIngredientes(){
        $ingredientes = CadastroIngredientes::all();
        return $ingredientes;
    }

    public function excluirIngrediente($id){
        $ingrediente = CadastroIngredientes::find($id);
        $deleteIngrediente = $ingrediente->delete();
        return $deleteIngrediente;

    }

    public function editarIngrediente(Request $request, $id){
        $ingrediente = CadastroIngredientes::find($id);

        $ingrediente->update([
            'ordem' => $request->input('ordem'),
            'codigo' => $request->input('codigo'),
            'descricao' => $request->input('descricao'),
            'previstoKG' => $request->input('previstoKG'),
        ]);
    }
}
