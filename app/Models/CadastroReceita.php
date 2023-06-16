<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cadastroReceita extends Model{

    protected $table = 'receita';
    public $timestamps = false;

    protected $fillable = [
        'receita'
    ];

    public function ingredientes(){
        return $this->hasMany(CadastroIngrediente::class, 'receita_id');
    }
}