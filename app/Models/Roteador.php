<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roteador extends Model
{
    use HasFactory;

    /* Por questão de segurança, o "fillable" é para dizer quais são
       os únicos campos que serão aceitos pelo model. O usuário poderia
       tentar inspecionar e injetar algum campo a mais, lá no front. */
    /* Modo massivo */
    protected $fillable = [
        'banda', 'datanota', 'macaddress', 'marca', 'modelo', 'notafiscal',
        'serial', 'situacao', 'observacao', 'imagem'
    ];

    public function rules()
    {
        return [
            'imagem' => 'required|file|mimes:png,docx,xlsx,pdf,ppt,jpeg,mp3',
            'banda' => 'required',
            'datanota' => 'required',
            'macaddress' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'notafiscal' => 'required',
            'serial' => 'required',
            'situacao' => 'required',
            'observacao' => 'required'
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
            'imagem.mimes' => 'Somente arquivos do tipo png,docx,xlsx,pdf,ppt,jpeg,mp3',
            'nome.unique' => 'O nome da antena já existe',
            'nome.min' => 'O nome deve ter pelo menos 3 caracteres'
        ];
    }
}
