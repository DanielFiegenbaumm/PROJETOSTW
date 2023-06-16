<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CadastroController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [LoginController::class, 'loginView'])->name('loginView');
Route::post('/auth', [LoginController::class, 'auth'])->name('auth.user');
Route::get('/cadastroLogin', [LoginController::class, 'cadastroLogin'])->name('cadastroLogin');
Route::post('/cadastrarUsuario', [LoginController::class, 'cadastrarUsuario'])->name('cadastrarUsuario');


Route::middleware(['auth'])->group(function () {
    Route::get('/cadastro', [CadastroController::class, 'cadastroReceitaView'])->name('cadastroReceitaView');
    Route::post('/cadastrarReceita', [CadastroController::class, 'cadastrarReceita']);
    Route::get('/listarReceitas', [CadastroController::class, 'listarReceitas']);
    Route::delete('/excluirReceita/{id}', [CadastroController::class, 'excluirReceita'])->name('receita.excluir');
    Route::put('/editarReceita/{id}', [CadastroController::class, 'editarReceita'])->name('receita.editar');
    Route::get('/adicionarIngredientes/{id}', [CadastroController::class, 'cadastroIngredienteView']);
    Route::get('/busca/receitas/{id}', [CadastroController::class, 'buscaReceita']);
    Route::post('/cadastrar/ingredientes/{id}', [CadastroController::class, 'cadastrarIngredientes']);
    Route::get('/listarIngredientes', [CadastroController::class, 'listarIngredientes']);
    Route::delete('/excluirIngrediente/{id}', [CadastroController::class, 'excluirIngrediente'])->name('ingrediente.excluir');
    Route::put('/editarIngrediente/{id}', [CadastroController::class, 'editarIngrediente'])->name('ingrediente.editar');
    Route::post('/encerrarSessao', function (Request $request) {
        Auth::logout();
        // Retornar uma resposta de sucesso, se necessário
        return response()->json(['message' => 'Sessão encerrada com sucesso']);
    });
});

