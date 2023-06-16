<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CadastroIngredientes extends Model{
    protected $table = 'ingrediente';
    public $timestamps = false;

    protected $fillable = [
        'receita_id',
        'ordem',
        'codigo',
        'descricao',
        'previstoKG'
    ];

    public function receita()
    {
        return $this->belongsTo(CadastroReceita::class, 'receita_id');
    }
}