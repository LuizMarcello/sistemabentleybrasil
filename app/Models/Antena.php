<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antena extends Model
{
    use HasFactory;

    /* Modo massivo */
    protected $fillable = ['nome', 'imagem'];

    public function rules()
    {
        return [
            'nome' => 'required|unique:antenas,nome, ' . $this->id . '|min:3',
            'imagem' => 'required'
        ];

        /* A validação "unique" tem 3 parâmetros:
           1) Qual tabela
           2) Nome da coluna que será pesquisada nesta tabela
           3) id do registro que será desconsiderado na pesquisa */
    }

    public function feedback()
    {
        return  [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O nome da antena já existe',
            'nome.min' => 'O nome deve ter pelo menos 3 caracteres'
        ];
    }
}
