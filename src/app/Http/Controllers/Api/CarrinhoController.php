<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Produto;
use App\Models\Aux_carrinho_produto;
use App\Models\Aux_carrinho_promocao;
use App\Models\Carrinho;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Log;

//use Illuminate\Support\Facades\Log;

class CarrinhoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
   
        Log::debug("Autenticando o add de itens ao carrinho...");
    
        try {
            
             $user =  auth()->userOrFail();
             Log::debug("User ".$user->email." Autenticando");
         } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
             Log::debug("Autenticação falhou para salvar o item do carrinho...Error = ".$e->getMessage());
             return response()->json($e->getMessage(),401);
            
         }
         Log::debug("Usuario autenticado, Salvando os itens do carrinho...");

        $data = $request->all(); //pegar todo
       
        $auxCarrinho = [];
        $qtdProduto = (isset($request['qtdProduto'])) ? $request['qtdProduto'] : null;
        $valorTotalProduto = (isset($request['valorTotalProduto'])) ? $request['valorTotalProduto'] : null;
        $atributos = (isset($request['listAtributos'])) ? $request['listAtributos'] : null; //pegar elementos da lista de atributos
        $idProduto = (isset($request['produtoId'])) ? $request['produtoId'] : null;
        $idPromocao = (isset($request['promocaoId'])) ? $request['promocaoId'] : null;
        $idBusine = (isset($request['idBusine'])) ? $request['idBusine'] : 0;
        $idUser = (isset($request['idUser'])) ? $request['idUser'] : 0;
        $obsPedido = (isset($request['obs_pedido'])) ? $request['obs_pedido'] : "";
        $save = false;
        Log::debug($atributos);

        // die();
        //valor total dos produtos =  $data["valorTotalProduto"]
        //qtd produto ou promoção  = $data["qtdProduto"]
        // $data["valorTotalProduto"]
        // $data["qtdProduto"]
        // $data["produtoId"],
        // $data["promocaoId]
        // $data['idUser'],
        // $data['idBusine'],
        // $data['listAtributos']

        try {
            $carrinho = [
                'valor_total_prod' => $data["valorTotalProduto"],
                'user_id' => $idUser,
                'busine_id' => $idBusine,
                'faturado' => 0,
            ]; //pegar apenas o carrinho

            //procurar se o usuario já tem carrinho para essa empresa
            $carrinhoBusine = DB::table('carrinhos')
                ->select('carrinhos.id')
                ->where('user_id', '=', $idUser)
                ->where('busine_id', '=', $idBusine)
                ->where('faturado', '=', 0)
                ->get()->toArray();
            // Log::debug($carrinhoBusine[0]->id);
            // Log::debug($carrinhoBusine->id);
            //cria o carrinho caso o usuario não tenho um
            if (!$carrinhoBusine) :
                $carrinho_create = Carrinho::create($carrinho);

                if ($carrinho_create):
                    $save = $this->saveCarrinhoAux(
                        $idProduto,
                        $idPromocao,
                        $carrinho_create->id,
                        $atributos, $qtdProduto,
                        $valorTotalProduto,
                        $obsPedido
                    );

                endif;

                return response()->json(['retorno' => $save]);

            endif;

            //atualiza o carrinho existente
            $save = $this->saveCarrinhoAux($idProduto, $idPromocao, $carrinhoBusine[0]->id, $atributos, $qtdProduto, $valorTotalProduto,$obsPedido);
            return response()->json(['retorno' => $save]);

        } catch (Exception $e) {
            return response()->json(['retorno' => $save]);
        }

    }
    public function saveCarrinhoAux($idProduto, $idPromocao, $idCarrinho, $atributos, $qtdProduto, $valorTotalProduto, $obsPedido)
    {
        $save = $this->updateProduto($idProduto, $idPromocao, $idCarrinho, $atributos, $qtdProduto, $valorTotalProduto, $obsPedido);
        if (!$save) {
            try {

                if ($idProduto) {
                    $auxCarrinho = [
                        'valor_total_prod' => $valorTotalProduto,
                        'qtd_produto' => $qtdProduto,
                        'carrinho_id' => $idCarrinho,
                        'produto_id' => $idProduto,
                        'promocao' => 0,
                        'obs_pedido' => $obsPedido,
                        'unique_cart_hash' => md5(uniqid(rand(), true)),
                    ];

                    //salvar o carrinho na aux_carrinho _ produtos
                    $auxCarrinho = Aux_carrinho_produto::create($auxCarrinho);

                    if ($auxCarrinho) {
                        //salvando os atributos
                        if ($atributos):
                            //Log::debug(gettype($auxCarrinho->id));
                            foreach ($atributos as $attr):
                             
                                Log::debug($attr['atributo_qtd']);

                                DB::table('attr_carrinhos')->insert([
                                    "aux_carrinho_id" => $auxCarrinho->id,
                                    "atributo_id" => $attr['atributo_id'],
                                    "atributo_qtd" => $attr['atributo_qtd'],
                                ]);
                            endforeach;
                        endif;
                        $save = true;
                    }
                }
                if ($idPromocao) {
                    $auxCarrinho = [
                        'valor_total_prod' => $valorTotalProduto,
                        'qtd_promocao' => $qtdProduto,
                        'carrinho_id' => $idCarrinho,
                        'promocao_id' => $idPromocao,
                        'promocao' => 1,
                        'obs_pedido' => $obsPedido,

                    ];
                    //salvar o carrinho na aux_carrinho _ promocao
                    $auxCarrinho = Aux_carrinho_promocao::create($auxCarrinho);
                    if ($auxCarrinho) {
                        $save = true;
                    }

                }
                return $save;
            } catch (Exception $e) {
                return $save;
            }
        }
        return $save;

    }
    public function updateProduto($idProduto, $idPromocao, $idCarrinho, $atributos, $qtdProduto, $valorTotalProduto)
    {
        $update = false;
        if (!$atributos) {
            try {
                if ($idProduto) {
                    $updateProduto = DB::table('aux_carrinho_produtos')
                        ->where('produto_id', $idProduto)
                        ->where('carrinho_id', $idCarrinho)
                        ->get()->toArray();

                    if ($updateProduto) {
                        $updateProd = Aux_carrinho_produto::find($updateProduto[0]->id);
                        $updateProd->valor_total_prod = $updateProduto[0]->valor_total_prod + $valorTotalProduto;
                        $updateProd->qtd_produto = $updateProduto[0]->qtd_produto + $qtdProduto;
                        $updateProd->save();

                        if ($updateProd) {
                            $update = true;
                            return $update;
                        }
                        return $update;
                    }
                    return $update;
                }

                if ($idPromocao) {
                    $updateProduto = DB::table('aux_carrinho_promocaos')
                        ->where('promocao_id', $idPromocao)
                        ->where('carrinho_id', $idCarrinho)
                        ->get()->toArray();

                    if ($updateProduto) {
                        $updateProd = Aux_carrinho_promocao::find($updateProduto[0]->id);
                        $updateProd->valor_total_prod = $updateProduto[0]->valor_total_prod + $valorTotalProduto;
                        $updateProd->qtd_promocao = $updateProduto[0]->qtd_promocao + $qtdProduto;
                        $updateProd->save();

                        if ($updateProd) {
                            $update = true;
                            return $update;
                        }
                        return $update;
                    }
                    return $update;
                }

                return $update;
            } catch (Exception $e) {
                return $update;
            }
        }
        return $update;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Log::debug("Autenticando a exclusão dos itens ao carrinho...");
    
        try {
             $user = auth()->userOrFail();
             Log::debug("User ".$user->email." Autenticando");
         } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
             Log::debug("Autenticação falhou para excluir o item do carrinho...Error = ".$e->getMessage());
             return response()->json($e->getMessage(),401);
            
         }
         Log::debug("Usuario autenticado, excluindo  itens do carrinho...");

        $idProduto = (isset($request['produtoId'])) ? $request['produtoId'] : null;
        $promocao = (isset($request['promocao'])) ? $request['promocao'] : 0;
        $idBusine = (isset($request['idBusine'])) ? $request['idBusine'] : 0;
        $idUser = (isset($request['idUser'])) ? $request['idUser'] : 0;
        $uniqueCarthash = (isset($request['uniqueCartHash'])) ? $request['uniqueCartHash'] : 0;

        Log::debug($uniqueCarthash);

        $save = false;
        //deletando o carrinho
        try {
            $carrinhoBusine = DB::table('carrinhos')
                ->select('carrinhos.id')
                ->where('user_id', '=', $idUser)
                ->where('busine_id', '=', $idBusine)
                ->where('faturado', '=', 0)
                ->get()->toArray();

            if ($carrinhoBusine) {
                if ($promocao == 0) {
                    $excluido = DB::table('aux_carrinho_produtos')
                        ->where([
                            'produto_id' => $idProduto,
                            'unique_cart_hash' => $uniqueCarthash,
                            'carrinho_id' => $carrinhoBusine[0]->id
                            ])
                        ->delete();

                    if ($excluido) {
                        $save = true;
                        Log::debug('Item do carrinho deletado com sucesso');
                        return response()->json(['retorno' => $save]);

                    }
                }
                $excluido = DB::table('aux_carrinho_promocaos')
                    ->where('promocao_id', $idProduto)
                    ->where('carrinho_id', $carrinhoBusine[0]->id)
                    ->delete();

                if ($excluido) {
                    $save = true;
                    Log::debug('Item do carrinho deletado com sucesso');
                    return response()->json(['retorno' => $save]);

                }

            }

            Log::debug('Item do carrinho não foi deletado!!!');
            return response()->json(['retorno' => $save]);

        } catch (Exception $e) {
            Log::debug('Item do carrinho não foi deletado!!!');
            return response()->json(['retorno' => $save]);
        }

    }

    public function listarCarrinho($idUser, $idBusine)
    {
        $retorno = array();
        Log::debug("Autenticando a listagem de itens do carrinho...");
       // $this->authUserApi();
       try {
            $user = auth()->userOrFail();
            Log::debug("User ".$user->email." Autenticado");

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            Log::debug("Autenticação falhou para a listagem de itens do carrinho...Error = ".$e->getMessage());
            return response()->json($retorno,401);
            //return response()->json(['error' => $e->getMessage()],401);
        }
        Log::debug("Usuario autenticado, retornando os itens do carrinho...");
        //select listar carrinho
        try {
            //retorno [{"id":1,"valor_total_prod":"50.00","qtd_produto":1,"nome_prod":"Carne de sol com macaxeira","desc_prod":"Carne de sol,macaxeira"},{"id":2,"valor_total_prod":"35.00","qtd_produto":4,"nome_prod":"Pizza GG Nordestina","desc_prod":"Borda recheada, massa especial, tomate, mussarela, chedar"},{"id":3,"valor_total_prod":"100.00","qtd_produto":5,"nome_prod":"A\u00e7ai 1L","desc_prod":"A\u00e7a\u00ed, mais complementos"},{"id":4,"valor_total_prod":"20.00","qtd_produto":3,"nome_prod":"A\u00e7ai 200ML","desc_prod":"A\u00e7a\u00ed, mais complementos"},{"id":5,"valor_total_prod":"75.50","qtd_produto":8,"nome_prod":"A\u00e7ai 500ML","desc_prod":"A\u00e7a\u00ed, mais complementos"}]
            //buscar as promoçoes
            $carrinhoPromocoes = DB::table('carrinhos')
                ->select(
                    'promocoes.id',
                    'aux_carrinho_promocaos.valor_total_prod',
                    'aux_carrinho_promocaos.qtd_promocao',
                    'aux_carrinho_promocaos.unique_cart_hash',
                    'promocoes.title_promocao',
                    'promocoes.decricao_promocao',
                    'aux_carrinho_promocaos.promocao'
                ) //DB::raw("COUNT(*) as qtdCarrinho")aux_carrinho_produtos
                ->join('aux_carrinho_promocaos', 'carrinho_id', '=', 'carrinhos.id')
                ->join('promocoes', 'promocoes.id', '=', 'aux_carrinho_promocaos.promocao_id')
                ->where([
                    'faturado' => 0,
                    'user_id' => $idUser,
                    'busine_id' => $idBusine,
                ]);

            $carrinho = DB::table('carrinhos')
                ->select(
                    'produtos.id',
                    'aux_carrinho_produtos.valor_total_prod',
                    'aux_carrinho_produtos.qtd_produto',
                    'aux_carrinho_produtos.unique_cart_hash',
                    'produtos.nome_prod',
                    'produtos.desc_prod',
                    'aux_carrinho_produtos.promocao'
                ) //DB::raw("COUNT(*) as qtdCarrinho")aux_carrinho_produtos
                ->join('aux_carrinho_produtos', 'carrinho_id', '=', 'carrinhos.id')
                ->join('produtos', 'produtos.id', '=', 'aux_carrinho_produtos.produto_id')
                ->where([
                    'faturado' => 0,
                    'user_id' => $idUser,
                    'busine_id' => $idBusine,
                ])
                ->unionAll($carrinhoPromocoes) //adiconar as promocoes ao carrinho
            //->orderBy('aux_carrinho_produtos.id')
                ->get()->toArray();

            Log::debug("Buscando o carrinho");
            //->where('table_B.b_1', '=',$num_sorteado )->orWhere('table_B.b_2', '=',$num_sorteado)->orWhere('table_B.b_3', '=',$num_sorteado)->orWhere('table_B.b_4', '=',$num_sorteado)->orWhere('table_B.b_5', '=',$num_sorteado)
            // ->orWhere('table_I.i_1', '=', $num_sorteado)->orWhere('table_I.i_2', '=',$num_sorteado)->orWhere('table_I.i_3', '=',$num_sorteado)->orWhere('table_I.i_4', '=',$num_sorteado)->orWhere('table_I.i_5', '=',$num_sorteado)
            if (!empty($carrinho)) {
                return response()->json($carrinho);
            } else {
                //Alterando o retorno da route list
                $retorno = [];
                return response()->json($retorno);

            }
        } catch (Exception $e) {
            //Alterando o retorno da route list
            $retorno = [];
            return response()->json($retorno);
        }

    }


    //REFATORAR ESSE METODO PARA ATENDER AS NECESSIDADES 
    public function listarItensCarrinhoQtd($idUser, $idBusine)
    {
        $retorno = array();

        //select listar carrinho
        try {
            //retorno [{"id":1,"valor_total_prod":"50.00","qtd_produto":1,"nome_prod":"Carne de sol com macaxeira","desc_prod":"Carne de sol,macaxeira"},{"id":2,"valor_total_prod":"35.00","qtd_produto":4,"nome_prod":"Pizza GG Nordestina","desc_prod":"Borda recheada, massa especial, tomate, mussarela, chedar"},{"id":3,"valor_total_prod":"100.00","qtd_produto":5,"nome_prod":"A\u00e7ai 1L","desc_prod":"A\u00e7a\u00ed, mais complementos"},{"id":4,"valor_total_prod":"20.00","qtd_produto":3,"nome_prod":"A\u00e7ai 200ML","desc_prod":"A\u00e7a\u00ed, mais complementos"},{"id":5,"valor_total_prod":"75.50","qtd_produto":8,"nome_prod":"A\u00e7ai 500ML","desc_prod":"A\u00e7a\u00ed, mais complementos"}]
            //buscar as promoçoes
            $carrinhoPromocoes = DB::table('carrinhos')
                ->select(
                    'promocoes.id',
                    'aux_carrinho_promocaos.valor_total_prod',
                    'aux_carrinho_promocaos.qtd_promocao',
                    'aux_carrinho_promocaos.unique_cart_hash',
                    'promocoes.title_promocao',
                    'promocoes.decricao_promocao',
                    'aux_carrinho_promocaos.promocao'
                ) //DB::raw("COUNT(*) as qtdCarrinho")aux_carrinho_produtos
                ->join('aux_carrinho_promocaos', 'carrinho_id', '=', 'carrinhos.id')
                ->join('promocoes', 'promocoes.id', '=', 'aux_carrinho_promocaos.promocao_id')
                ->where([
                    'faturado' => 0,
                    'user_id' => $idUser,
                    'busine_id' => $idBusine,
                ]);

            $carrinho = DB::table('carrinhos')
                ->select(
                    'produtos.id',
                    'aux_carrinho_produtos.valor_total_prod',
                    'aux_carrinho_produtos.qtd_produto',
                    'aux_carrinho_produtos.unique_cart_hash',
                    'produtos.nome_prod',
                    'produtos.desc_prod',
                    'aux_carrinho_produtos.promocao'
                ) //DB::raw("COUNT(*) as qtdCarrinho")aux_carrinho_produtos
                ->join('aux_carrinho_produtos', 'carrinho_id', '=', 'carrinhos.id')
                ->join('produtos', 'produtos.id', '=', 'aux_carrinho_produtos.produto_id')
                ->where([
                    'faturado' => 0,
                    'user_id' => $idUser,
                    'busine_id' => $idBusine,
                ])
                ->unionAll($carrinhoPromocoes) //adiconar as promocoes ao carrinho
            //->orderBy('aux_carrinho_produtos.id')
                ->get()->toArray();

            Log::debug("Buscando o carrinho");
            //->where('table_B.b_1', '=',$num_sorteado )->orWhere('table_B.b_2', '=',$num_sorteado)->orWhere('table_B.b_3', '=',$num_sorteado)->orWhere('table_B.b_4', '=',$num_sorteado)->orWhere('table_B.b_5', '=',$num_sorteado)
            // ->orWhere('table_I.i_1', '=', $num_sorteado)->orWhere('table_I.i_2', '=',$num_sorteado)->orWhere('table_I.i_3', '=',$num_sorteado)->orWhere('table_I.i_4', '=',$num_sorteado)->orWhere('table_I.i_5', '=',$num_sorteado)
            if (!empty($carrinho)) {
                return response()->json($carrinho);
            } else {
                //Alterando o retorno da route list
                $retorno = [];
                return response()->json($retorno);

            }
        } catch (Exception $e) {
            //Alterando o retorno da route list
            $retorno = [];
            return response()->json($retorno);
        }

    }
}
