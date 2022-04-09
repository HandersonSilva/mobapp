<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Promocao;


class PromocaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promocoes = Promocao::all();

        if(count($promocoes ) >0):
                return response()->json($promocoes);
        else:
                return response()->json(['status'=> Response::HTTP_NOT_FOUND]);
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

        $promocao = Promocao::create($dados);

        if($promocao):
                return response()->json($promocao);
        else:
            return response()->json(['status'=> Response::HTTP_NOT_FOUND]);
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promocao  = Promocao::find($id);

        if( !empty($promocao) ):
                return response()->json($promocao);
        else:
            return response()->json(['status'=> Response::HTTP_NOT_FOUND]);
        endif;

    }


    //listando os produtos de cada promocao
    public function promocaoProdutos(){
            $promocoes = Promocao::all();

            foreach($promocoes  as $key => $promo ){

                $promocao = Promocao::find($promo->id);
                $produtos = $promocao->produtos()->where('status_promo', '1')->get();

                //atribui os produtos da promoção
                $promocao_produtos[$key]  = [
                    'promocoes' => $promocao,
                    'produtos' => $produtos,
                ];

            }

            if( !empty($promocao_produtos) ):
                return response()->json($promocao_produtos);
            else:
                return response()->json(['status'=> Response::HTTP_NOT_FOUND]);
            endif;

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
