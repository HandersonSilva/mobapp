<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Atributo;


class AtributoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $atributos = Atributo::all();


        if(count($atributos ) > 0 ):

                return response()->json($atributos);

        else:

            $data = array(
                'message' => "Nenhum atributo cadastrado"
            );

            return response()->json($data);

        endif;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $dados  = $request->all();

        $atributo = Atributo::create($dados);

        if($atributo):
                $return = array(
                    'atributo' => $atributo,
                    'status' => Response::HTTP_OK,
                );

                return response()->json($return);
        else:
                return response()->json(['status' => Response::HTTP_NOT_FOUND]);
        endif;

         //return json_encode($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    public function atributoProduto($id){

        $atributo= Atributo::find($id);

         if(!empty($atributo)) {
            $produto = $atributo->produto()->get();
            if(count($produto ) > 0 ):

                $data = array(
                    'atributo' => $atributo,
                    'produto' => $produto,
                );
                  return response()->json($data);

            endif;

         }else{
            $data = array(
                'message' => "Not found"
            );

            return response()->json($data);
         }

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
