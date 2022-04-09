<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CategoriaAtributo;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

class CategoriaAtributoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias_atributo = CategoriaAtributo::all();

        if( count($categorias_atributo) > 0 ):
                $data = array(
                    'categoria_atributo' => $categorias_atributo,
                    'status' => Response::HTTP_OK,
                 );
                 return response()->json($data);
        else:
            return response()->json(Response::HTTP_NOT_FOUND);
        endif;

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
        $dados = $request->all();

        $categoriaAtributo = CategoriaAtributo::create($dados);

        if($categoriaAtributo):
                return response()->json($categoriaAtributo);
        else:
                return response()->json(Response::HTTP_NOT_FOUND);
        endif;

        //return json_encode( $dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //buscando as categorias e lista de atributos do produto
    public function show($id)
    {

        $categorias = CategoriaAtributo::all();
        $data_atributos =null;
        //percorre as categorias e busca os atributos apenas do produto passado {$id}
        foreach($categorias as $key => $categ){


                $atributos_categoria = $categ->atributos()
                ->where(['produto_id' => $id ])
                ->get();

                $categoria = null;
                foreach($atributos_categoria as $atributo){
                     $categoria =   DB::table('categoria_atributo')->where(['id' => $atributo->categoria_atributo_id])->get();
                }

            if($categoria != null && !empty($atributos_categoria)){
                    $data_atributos[] = array(
                        'categoria' =>   $categoria,
                        'atributos' => $atributos_categoria,
                    );

                }

        }

        return $data_atributos;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
