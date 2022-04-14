<?php

namespace App\Repositories;

/* Para poder tipar o parâmetro, conforme o model */
use Illuminate\Database\Eloquent\Model;

class AntenaRepository {

    /* Type-hinting( Sugestão de tipo - tipando ) */
    /* Construtor desta classe */

    public function __construct( Model $model ) {
        $this->model = $model;
    }

    public function selectAtributosRegistrosRelacionados( $atributos ) {
        $this->model = $this->model->with( $atributos );
        /* A query está sendo montada */
    }

    public function filtro( $filtros ) {
        $filtros = explode( ';', $filtro );
        foreach ( $filtros as $key => $condicao ) {
            $c =  explode( ':',  $condicao );
            $this->model = $this->model->where( $c[ 0 ], $c[ 1 ], $c[ 2 ] );
            /* A query está sendo montada */
        }
    }

    public function selectAtributos( $atributos ) {
        /* selectRaw() sabe lidar com: 'id,nome,imagem'( uma string só ) com
        'id', 'nome', 'imagem'( três strings separadas por virgula ) */
        $this->model = $this->model->selectRaw( $atributos );
        /* all() -> criando um obj de consulta + get() = collection */
        /* get() -> modificar a consulta -> collection */
    }

    public function getResultado() {
        return $this->model->get();
    }

}

?>

