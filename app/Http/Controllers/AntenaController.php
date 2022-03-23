<?php

namespace App\Http\Controllers;

use App\Models\Antena;
use Illuminate\Http\Request;

class AntenaController extends Controller
{
    /* Construtor desta classe, para quando o objeto
       (esta classe) for instanciada. Está usando a
       sugestão de tipo (type-hinting), para injetar
       a instância do respectivo model neste controller.
        */
    public function __construct(Antena $antena)
    {
        $this->aaantena = $antena;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$antenas = Antena::all();
        $antena = $this->aaantena->all();
        return $antena;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Modo massivo */
        //$antena = Antena::create($request->all());
        $antena = $this->aaantena->create($request->all());
        return $antena;
    }

    /**
     * Display the specified resource.
     *
     * @param Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $antena = $this->aaantena->find($id);
        return $antena;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Antena  $antena
     * @return \Illuminate\Http\Response
     */
    public function edit(Antena $antena)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*
        print_r($request->all()); //Os dados atualizados.
        echo '<hr>';
        print_r($antena->getAttributes()); //Os dados antigos, antes do update
        */

        //$antena->update($request->all());
        $antena = $this->aaantena->find($id);
        $antena->update($request->all());
        return $antena;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $antena = $this->aaantena->find($id);
        $antena->delete();
        return ['msg' => 'A antena foi removida com sucesso!'];
    }
}
