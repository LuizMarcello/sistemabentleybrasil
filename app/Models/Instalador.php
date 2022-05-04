<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalador extends Model {
    //use SoftDeletes;
    use HasFactory;

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'instaladores';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /* Por questão de segurança, o 'fillable' é para dizer quais são
    os únicos campos que serão aceitos pelo model. O usuário poderia
    tentar inspecionar e injetar algum campo a mais, lá no front. */
    /* Modo massivo */
    protected $fillable = [
        'nome', 'cpf', 'rg', 'celular', 'telefone', 'email', 'cep', 'bairro', 'cidade',
        'estado', 'observacao', 'situacao', 'rua', 'numero', 'dataNascimento', 'imagem'
    ];

    public function rules() {
        return [
            'nome' => 'required|unique:antenas,nome, ' . $this->id . '|min:3',
            //'imagem' => 'required|file|mimes:png,docx,xlsx,pdf,ppt,jpeg,mp3',
            //'cpf' => 'required',
            //'rg' => 'required',
            //'celular' => 'required',
            //'telefone' => 'required',
            //'email' => 'required',
            //'cep' => 'required',
            //'bairro' => 'required',
            //'cidade' => 'required'
            //'estado' => 'required'
            //'observacao' => 'required'
            //'situacao' => 'required'
            //'rua' => 'required'
            //'numero' => 'required'
            //'dataNascimento' => 'required'
        ];

        /* A validação 'unique' tem 3 parâmetros:
        1 ) Qual tabela
        2 ) Nome da coluna que será pesquisada nesta tabela
        3 ) id do registro que será desconsiderado na pesquisa */
    }

    /* Relacionamentos: */

    public function instalacoes() {
        /* Um instalador possui várias instalações */
        return $this->hasMany( 'App\Models\Instalacao' );
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
