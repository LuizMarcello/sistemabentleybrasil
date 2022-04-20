<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalacao extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'instalacaos';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /* Por questão de segurança, o "fillable" é para dizer quais são
       os únicos campos que serão aceitos pelo model. O usuário poderia
       tentar inspecionar e injetar algum campo a mais, lá no front. */
    /* Modo massivo */
    protected $fillable = [
        'cliente_id',  'cep', 'rua', 'numero', 'bairro', 'cidade', 'estado', 'celular', 'telefone',
        'status', 'banda', 'instalador_id', 'distribuidor_id', 'plano_id', 'dataInstalacao',
        'observacao', 'imagem', 'notaFiscal', 'dataDaNota'
    ];

    public function rules()
    {
        return [
            //'imagem' => 'required|file|mimes:png,docx,xlsx,pdf,ppt,jpeg,mp3',
            //'cliente_id' => 'required',
            //'rua' => 'required',
            //'numero' => 'required',
            //'bairro' => 'required',
            //'cidade' => 'required',
            //'estado' => 'required',
            //'celular' => 'required',
            //'telefone' => 'required',
            //'status' => 'required'
            //'banda' => 'required'
            //'instalador_id' => 'required'
            //'distribuidor_id' => 'required'
            //'plano_id' => 'required'
            //'dataInstalacao' => 'required'
            //'observacao' => 'required'
            //'imagem' => 'required'
            //'notaFiscal' => 'required'
            //'dataDaNota' => 'required'
        ];

        /* A validação "unique" tem 3 parâmetros:
            1) Qual tabela
            2) Nome da coluna que será pesquisada nesta tabela
            3) id do registro que será desconsiderado na pesquisa */
    }

    /* Relacionamento: */
    public function cliente()
    {
        /* Uma instalação possui um unico cliente */
        return $this->belongsTo('App\Models\Cliente');
    }

    /* Relacionamento: */
    public function instalador()
    {
        /* Uma instalação possui um unico instalador */
        return $this->belongsTo('App\Models\Instalador');
    }

    /* Relacionamento: */
    public function distribuidor()
    {
        /* Uma instalação possui um unico distribuidor */
        return $this->belongsTo('App\Models\Distribuidor');
    }

    /* Relacionamento: */
    public function plano()
    {
        /* Uma instalação possui um unico distribuidor */
        return $this->belongsTo('App\Models\Plano');
    }

    public function feedback()
    {
        return  [
            //'required' => 'O campo :attribute é obrigatório',
            //'imagem.mimes' => 'Somente arquivos do tipo png,docx,xlsx,pdf,ppt,jpeg,mp3',
            //'nome.unique' => 'O nome da antena já existe',
            //'nome.min' => 'O nome deve ter pelo menos 3 caracteres'
        ];
    }
}
