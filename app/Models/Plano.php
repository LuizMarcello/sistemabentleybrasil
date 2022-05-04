<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model {
    use HasFactory;

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'planos';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /* Por questão de segurança, o 'fillable' é para dizer quais são
    os únicos campos que serão aceitos pelo model. O usuário poderia
    tentar inspecionar e injetar algum campo a mais, lá no front. */
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'banda', 'cir', 'equipamento', 'nome', 'valor', 'valordecusto',
        'valormensal', 'velocmaxdown', 'velocmaxup', 'velocmindown', 'velocminup', 'observacao'
    ];

    public function rules() {
        return [
            //'banda' => 'required'
            //'cir' => 'required',
            //'equipamento' => 'required',
            'nome' => 'required',
            //'situacao' => 'required',
            //'valor' => 'required',
            //'valordecusto' => 'required',
            //'valormensal' => 'required',
            //'velocmaxdown' => 'required'
            //'velocmaxup' => 'required'
            //'velocmindown' => 'required'
            //'velocminup' => 'required'
            //'observacao' => 'required'

        ];

        /* A validação 'unique' tem 3 parâmetros:
        1 ) Qual tabela
        2 ) Nome da coluna que será pesquisada nesta tabela
        3 ) id do registro que será desconsiderado na pesquisa */
    }

    public function feedback() {
        return  [
            'required' => 'O campo :attribute é obrigatório',
            'imagem.mimes' => 'Somente arquivos do tipo png,docx,xlsx,pdf,ppt,jpeg,mp3',
            'nome.unique' => 'O nome da antena já existe',
            'nome.min' => 'O nome deve ter pelo menos 3 caracteres'
        ];
    }
}
