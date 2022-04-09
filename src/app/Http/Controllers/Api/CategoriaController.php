<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Busine;
use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

class CategoriaController extends Controller
{
    /**
     * Lista todas as categorias
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();

        if (count($categorias) > 0):
            return response()->json(['data' => $categorias, 'status' => Response::HTTP_OK]);

        else:
            return response()->json(['status' => Response::HTTP_NOT_FOUND]);

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
     * Insere uma nova categoria
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = $request->all();

        $categoria = Categoria::create($dados);

        if ($categoria):
            $retorno = array(
                'data' => $categoria,
                'status' => Response::HTTP_OK,
            );
            return response()->json($retorno);
        else:
            $retorno = array(
                'status' => Respose::HTTP_NOT_FOUND,
            );

        endif;

    }

    /**
     * Lista todos os produtos por categoria
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = Categoria::find($id);

        if ($categoria):
            return response()->json(['data' => $categoria, 'status' => Response::HTTP_OK]);
        else:
            return response()->json(['status' => Response::HTTP_NOT_FOUND]);
        endif;
    }

/*
 *
 *retorna os produtos da categoria
 */

    public function produtosCategoria($busineId)
    {
        //Log::debug("controle categoria Empresas  id = ".$busineId);

        try {
            $busine = Busine::find($busineId);
            $categorias = $busine->categorias()->get();
            $categoria_produtos = array();

            foreach ($categorias as $key => $categ) {
                $categoria_produtos[$key] = [
                    'categoria' => $categ,
                    'produtos' => $categ->produtos()->get(), //busca os produtos da categoria retornada
                ];
            }
            //  $categoria_produtos['horario_busines'] = $horario_funcionamento;

            Log::debug("Categorias recuperadas com sucesso");
        } catch (Exception $e) {

            Log::debug("Erro ao recuperar as categorias" . $e->getMessage());
        }

//         Log::debug("controle categoria Empresas ".$busine);
        //         Log::debug("controle categoria Categoria das empresas = ".$categorias);

        //percorre todas as categorias e a cada interacao filtra a categoria e os produtos relacionados a ela

        if (!empty($categoria_produtos)):
            return response()->json($categoria_produtos);
        else:
            return response()->json(['status' => Response::HTTP_NOT_FOUND]);
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
