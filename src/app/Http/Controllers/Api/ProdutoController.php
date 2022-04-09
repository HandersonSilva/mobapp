<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Http\Response;
use App\Models\PromocaoProduto;
use App\Models\Categoria;
use App\Models\Promocao;
use App\Models\Atributo;
use Illuminate\Support\Facades\DB;



class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $produtos = Produto::all();

         if(count($produtos) > 0):
                $data = array(
                    'produtos'=>$produtos,
                    'status' =>  Response::HTTP_OK,
                );
                return response()->json($data);
         else:
            $retorno = array(
                'status'=>Response::HTTP_NOT_FOUND,
            );
                return response()->json($retorno);
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
            $dados = $request->all();

            $produto_create = Produto::create($dados);

            if($produto_create) :
             $retorno = array(
                 'data'=> $produto_create,
                 'status'=> Response::HTTP_OK,
             );
                return response()->json($retorno);
        else:
            $retorno = array(
                'status'=>Respose::HTTP_NOT_FOUND,
            );

        endif;
    }

    /**
     *Lista o produto e sua categoria
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            $produto = Produto::find($id);

            if(!empty($produto)):
                return response()->json($produto);
         else:
            $retorno = array(
                'status'=>Response::HTTP_NOT_FOUND,
            );
                return response()->json($retorno);
         endif;

    }

    public function produtoAtributos($id){
            $produto = Produto::find($id);

            /*foreach($produtos as $key => $produto){
                   $prod = Produto::find($produto->id);

                   $prod_atributos[$key] = [
                            'produto' => $prod,
                            'atributos' => $prod->atributos()->get(),
                   ];

            }*/


            return json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $dados = $request->all();
        $produto = Produto::find($id);

        if( !empty($produto) ):
                $update = $produto->update($dados);
                 if($update):
                        return response()->json(['message' => "Produto atualizado com sucesso"]);
                 else:
                        return response()->json(['message' => "Erro ao tentar atualizar o produto"]);
                 endif;

        else:
                return response()->json(['message' => "Produto não encontrado"]);
        endif;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = Produto::find($id);
        $delete = null;

        //primeiro remove o produto de de todas as promocoes em que ele faça parte
        $remove_prod_promo = DB::table('promocao_produto')
                       ->where([
                           'produto_id' => $id
                       ])
                       ->delete();

                       if($remove_prod_promo ) ://se conseguir remover o produto das promocoes, entao remove da tabela de produtos
                           $delete = $produto->delete();
                       endif;


        if($delete){
            $data = [
                'status'=> Response::HTTP_OK,
                'message' => "success"
            ];
        }else{
            $data = [
                'status'=> Response::HTTP_NOT_FOUND,
                'message' => "Error"
            ];
        }

        return response()->json($data);
    }
}
