<?php

namespace App\Repositories;

use App\Repositories\Contracts\PedidoRepositoryInterface;
use App\Models\Pedidos;
use Illuminate\Http\Request;
use App\Models\Aux_pedido_carrinho;
use App\Models\Carrinho;
use App\Models\User;
use App\Models\Busine;
use App\Models\FormasPagamentos;
use Illuminate\Support\Facades\DB;
use Log;
use PagarMe;
use PagarMe\Exceptions\PagarMeException;

//constantes para status de pedidos
define("CASH_PAYMENT_CODE", "DH");
define("CARD_PAYMENT_CODE", "CT");
define("PEDIDO_ACEITE", "Aguardando o aceite");
define("PEDIDO_APROVADO", "Pedido aprovado");
define("PEDIDO_SAIU_ENTREGA", "Saiu para entrega");
define("PEDIDO_CANCELADO", "Pedido cancelado");


class PedidoRepository implements PedidoRepositoryInterface
{
  /**
   * Model class for repo.
   *
   * @var string
   */
  protected $modelClass;


  public function __construct(Pedidos $pedidos){
      $this->modelClass = $pedidos;
  }

  public function create(Request $request)
  {
        $data = $request->all();
        Log::debug($data);
        $pedido = isset($data['pedido']) ? $data['pedido'] : null;
        $formasPagamento = isset($data['forma_pagamento']) ? $data['forma_pagamento'] : null;
        $idBusine = $pedido['busines_id'];
        $idUser = $pedido['user_id'];

        if($formasPagamento['form_payment_code'] == CASH_PAYMENT_CODE){
            return $this->cashPayment($pedido, $formasPagamento, $idBusine, $idUser );
        }else if($formasPagamento['form_payment_code'] == CARD_PAYMENT_CODE){
            return $this->cardPayment($pedido, $formasPagamento, $idBusine, $idUser);
        }
    }


    public function cashPayment($pedido, $formasPagamento, $idBusine, $idUser)
    {

        $save = false;
        try {
            //procurar se o usuario já tem carrinho para essa empresa
            $carrinhoBusine = DB::table('carrinhos')
                ->select('carrinhos.id', 'busines.nome_fantasia')
                ->join('busines', 'busines.id', '=', 'carrinhos.busine_id')
                ->where('user_id', '=', $idUser)
                ->where('busines.id' ,'=',$idBusine)
                ->where('faturado', '=', 0)
                ->get()->toArray();
            Log::debug($carrinhoBusine);

            if ($carrinhoBusine) {
                Log::debug("Pagamento");

                $formasPagamento = FormasPagamentos::create($formasPagamento);

                Log::debug($formasPagamento);
                if ($formasPagamento) {

                    $pedido['formas_id'] = $formasPagamento->id;
                    $pedido['name_empresa'] = $carrinhoBusine[0]->nome_fantasia;

                    $pedido = Pedidos::create($pedido);
                    $pedido->codigo = $this->codeGenerate($idUser, $pedido->id);
                    $pedido->save();
                    Log::debug("Pedido salvo");
                    Log::debug($pedido);
                    if ($pedido) {

                        $auxPedidocarrinho = [
                            "carrinho_id" => $carrinhoBusine[0]->id,
                            "pedidos_id" => $pedido->id,
                        ];
                        $auxPedidocarrinho = Aux_pedido_carrinho::create($auxPedidocarrinho);
                        if ($auxPedidocarrinho) {
                            $closeCarrinho = Carrinho::find($carrinhoBusine[0]->id);
                            if ($closeCarrinho) {
                                $closeCarrinho->faturado = 1;
                                $closeCarrinho->save();
                                Log::debug("closeCarrinho" . $closeCarrinho);
                                if ($closeCarrinho) {

                                    return response()->json(["success" => true, "message" => "Pedido enviado com sucesso\nAguarde o estabelecimento aceitar o seu pedido."]);
                                }
                                return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);
                            }
                            return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);
                        }

                        //destruir o pedido
                        $pedido->delete();
                        return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);
                    }
                    return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);
                }
                return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);
            }

            return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);
        } catch (Exception $e) {
            return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);
        }
    }

    public function cardPayment($pedido, $formasPagamento, $idBusine, $idUser)
    {


        $save = false;
        $pagarme = new PagarMe\Client('ak_test_hDQZyhCpKbvW36dLsnHvnybS5eBOtG');
        $itens = $this->itensPagarme($idUser,$idBusine);

        Log::debug($itens);
      //  Log:debug( $formasPagamento['card_expiration'] );
        $formasPagamento['card_number'] = base64_decode($formasPagamento['card_number']);
        $formasPagamento['card_expiration'] = str_replace("/", "", $formasPagamento['card_expiration']);

        Log::debug("pagamento em cartão");
        Log::debug($pedido);
        Log::debug($formasPagamento['liquido']);

        $user = User::find($idUser);
        $userAddress = $user->address()->get();

        $busine = Busine::find($idBusine);
        $busineConfig = DB::table('busines')
                        ->select('*')
                        ->join('busine_configs', 'busines.busine_configs_id', '=', 'busine_configs.id')
                        ->where('busines.id', $busine->id)
                        ->get();

        Log::debug($user);
        Log::debug($userAddress[0]->cidade);
        Log::debug($busine);
        Log::debug($busineConfig);
        Log::debug(str_replace( '.', '', number_format($formasPagamento['liquido'], 2, '.', '')));


        $customer = array(
            'external_id' => (string)$idUser,
            'name' => $user->nome,
            'type' => 'individual',
            'country' => 'br',
            'documents' => [
                [
                'type' => "cpf",
                'number' => str_replace("-", "", $user->cpf)
                ]
            ],
            'phone_numbers' => [ "+55".$user->telefone],
            'email' => $user->email
        );

        $billing  = array(
            'name' => $user->nome,
            'address' => [
                'country' => 'br',
                'street' => $userAddress[0]->rua,
                'street_number' => $userAddress[0]->numero,
                'state' => $userAddress[0]->UF,
                'city' => $userAddress[0]->cidade,
                'neighborhood' => $userAddress[0]->bairro,
                'zipcode' => str_replace("-", "", $userAddress[0]->cep),
            ]
        );

        $number_format = number_format($formasPagamento['liquido'], 2, '.', '');
        Log::debug("Nome do cliente =".$user->nome);
        try {
            $transaction = $pagarme->transactions()->create([
                'amount' => str_replace( '.', '', $number_format ),
                'payment_method' => 'credit_card',
                'card_holder_name' => $formasPagamento['card_name'],
                'card_cvv' => $formasPagamento['card_csv'],
                'card_number' => $formasPagamento['card_number'],
                'card_expiration_date' => $formasPagamento['card_expiration'],
                'customer' => $customer,
                'billing' => $billing,
                'shipping' => [
                    'name' => $user->nome,
                    'fee' => str_replace('.', '', $busineConfig[0]->valor_frete),
                    'delivery_date' => $pedido['date_inicio'],
                    'expedited' => false,
                    'address' => [
                      'country' => 'br',
                      'street' => $userAddress[0]->rua,
                      'street_number' => $userAddress[0]->numero,
                      'state' => $userAddress[0]->UF,
                      'city' => $userAddress[0]->cidade,
                      'neighborhood' => $userAddress[0]->bairro,
                      'zipcode' => str_replace("-", "", $userAddress[0]->cep)
                    ]
                ],
                'items' => $itens
            ]);

            if($transaction){
                Log::debug('Pedido cartao criado com sucesso na API pagar.me');
                Log::debug(json_encode($transaction));

                try {
                    //procurar se o usuario já tem carrinho para essa empresa
                    $carrinhoBusine = DB::table('carrinhos')
                        ->select('carrinhos.id', 'busines.nome_fantasia')
                        ->join('busines', 'busines.id', '=', 'carrinhos.busine_id')
                        ->where('user_id', '=', $idUser)
                        ->where('faturado', '=', 0)
                        ->get()->toArray();
                    Log::debug($carrinhoBusine);

                    if ($carrinhoBusine) {
                        Log::debug("Pagamento");

                        $formasPagamento['card_number'] = base64_encode($formasPagamento['card_number']);
                        $formasPagamento["transaction_id"] = (string) $transaction->id;//adiciona o id da transação da pagar.me
                        $formasPagamento = FormasPagamentos::create($formasPagamento);

                        Log::debug($formasPagamento);
                        if ($formasPagamento) {

                            $pedido['formas_id'] = $formasPagamento->id;
                            $pedido['name_empresa'] = $carrinhoBusine[0]->nome_fantasia;

                            $pedido = Pedidos::create($pedido);
                            $pedido->codigo = $this->codeGenerate($idUser, $pedido->id);
                            $pedido->save();
                            Log::debug("Pedido salvo");
                            Log::debug($pedido);
                            if ($pedido) {

                                $auxPedidocarrinho = [
                                    "carrinho_id" => $carrinhoBusine[0]->id,
                                    "pedidos_id" => $pedido->id,
                                ];
                                $auxPedidocarrinho = Aux_pedido_carrinho::create($auxPedidocarrinho);
                                if ($auxPedidocarrinho) {
                                    $closeCarrinho = Carrinho::find($carrinhoBusine[0]->id);
                                    if ($closeCarrinho) {
                                        $closeCarrinho->faturado = 1;
                                        $closeCarrinho->save();
                                        Log::debug("closeCarrinho" . $closeCarrinho);
                                        if ($closeCarrinho) {

                                            return response()->json(["success" => true, "message" => "Pedido enviado com sucesso\nAguarde o estabelecimento aceitar o seu pedido."]);
                                        }
                                        return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);
                                    }
                                    return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);
                                }

                                //destruir o pedido
                                $pedido->delete();
                                return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);
                            }
                            return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);
                        }
                        return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);
                    }

                    return response()->json(["success" => false, "message" => "O envio do seu pedido falhou"]);

                } catch (PagarMeException $e) {
                    Log::error($e->getMessage());
                    return response()->json(["success" => false, "message" => "O envio do seu pedido falhou, ".$e->getMessage()]);
                }
            }else{
                return response()->json(["success" => false, "message" => "Falha no processamento do pagamento"]);
            }

        } catch (PagarMeException $e) {
            Log::debug($e->getMessage());
            return response()->json(["success" => false, "message" => $e->getMessage()]);
        }

    }

    public function itensPagarme($idUser,$idBusine){
        $itens = [];
        try{
            $carrinhoBusine = DB::table('carrinhos')
            ->select('carrinhos.id')
            ->join('busines', 'busines.id', '=', 'carrinhos.busine_id')
            ->where('user_id', '=', $idUser)
            ->where('busines.id' ,'=',$idBusine)
            ->where('faturado', '=', 0)
            ->get()->toArray();

        Log::debug("id do carrinho resgate de itens ".$carrinhoBusine[0]->id);



            if ($carrinhoBusine) {
                $promocao = DB::table('aux_carrinho_promocaos')
                    ->select(
                        'aux_carrinho_promocaos.promocao_id',
                        'promocoes.title_promocao',
                        'aux_carrinho_promocaos.valor_total_prod',
                        'aux_carrinho_promocaos.qtd_promocao'

                    ) //DB::raw("COUNT(*) as qtdCarrinho")aux_carrinho_produtos
                    ->join('carrinhos', 'carrinhos.id', '=', 'aux_carrinho_promocaos.carrinho_id')
                    ->join('promocoes', 'promocoes.id', '=', 'aux_carrinho_promocaos.promocao_id')
                    ->where([
                        'aux_carrinho_promocaos.carrinho_id' => $carrinhoBusine[0]->id,
                    ]);

                $produtos = DB::table('aux_carrinho_produtos')
                    ->select(
                        'aux_carrinho_produtos.produto_id',
                        'produtos.nome_prod',
                        'aux_carrinho_produtos.valor_total_prod',
                        'aux_carrinho_produtos.qtd_produto'
                    ) //DB::raw("COUNT(*) as qtdCarrinho")aux_carrinho_produtos
                    ->join('carrinhos', 'carrinhos.id', '=', 'aux_carrinho_produtos.carrinho_id')
                    ->join('produtos', 'produtos.id', '=', 'aux_carrinho_produtos.produto_id')
                    ->where([
                        'aux_carrinho_produtos.carrinho_id' => $carrinhoBusine[0]->id,
                    ])
                    ->unionAll($promocao) //adiconar as promocoes ao carrinho
                //->orderBy('aux_carrinho_produtos.id')
                    ->get()->toArray();

                    Log::debug($produtos);

                    //montando os itens para o pagarme
                    if($produtos){
                        for($i = 0; $i < sizeof($produtos); $i++){

                           $itens[$i] = [
                                'id' => (string)$produtos[$i]->produto_id,
                                'title' => $produtos[$i]->nome_prod,
                                'unit_price' => str_replace(".", "", $produtos[$i]->valor_total_prod),
                                'quantity' => $produtos[$i]->qtd_produto,
                                'tangible' => true
                           ];


                        }
                    }

            }

        }catch(Exception $e){
            Log::debug("Ocorreu um erro ao realizar operacoes no banco de dados error = ".$e->getMessage());
        }

        return $itens;
    }

    public function listAll($userId)
    {
        Log::debug("Listando os pedidos user = " . $userId);
        try {
            $pedidos = DB::table('pedidos')
                ->select('pedidos.*', 'formas_pagamentos.total')
                ->join('formas_pagamentos', 'formas_pagamentos.id', '=', 'pedidos.formas_id')
                ->where('user_id', '=', $userId)
                ->orderBy('id', 'desc')
                ->get()->toArray();

            if ($pedidos) {
                Log::debug("Retornado os pedidos para o user = " . $userId);

                return response()->json($pedidos);
            }

            Log::debug("Erro ao retornar os pedidos para o user = " );
            Log::debug($pedidos);
            return response()->json($pedidos);
        } catch (Exception $e) {
            Log::debug("Erro ao retornar os pedidos para o user = " . $userId."Error ".$e->getMessage());
            return response()->json(null);
        }
    }

    public function findByOrderId($orderId){
        $valor_atrr = 1;
        Log::debug("Listando o pedidos = " . $orderId);
        try {
            $pedidos = DB::table('pedidos')
                ->select(
                    'pedidos.id',
                    'pedidos.*',
                    'formas_pagamentos.name',
                    'formas_pagamentos.total',
                    'formas_pagamentos.desconto',
                    'formas_pagamentos.liquido',
                    'formas_pagamentos.form_payment_code',
                    'formas_pagamentos.installment',
                    'formas_pagamentos.form_payment_code',
                    'formas_pagamentos.number_installments',
                    'formas_pagamentos.card_name',
                    'formas_pagamentos.card_number',
                    'formas_pagamentos.card_flag',
                    'formas_pagamentos.amount_transshipment',
                    'formas_pagamentos.need_transshipment',
                    'formas_pagamentos.get_transshipment'
                )
                ->join('formas_pagamentos', 'formas_pagamentos.id', '=', 'pedidos.formas_id')
                ->join('aux_pedido_carrinhos', 'pedidos_id', '=', 'pedidos.id')
                ->where([
                    'pedidos.id' => $orderId,
                ])
                ->orderBy('pedidos.id', 'desc')
                ->get()->toArray();

            if ($pedidos) {
                $promocaoPedido = DB::table('pedidos')
                    ->select(
                        'promocoes.id',
                        'aux_carrinho_promocaos.valor_total_prod',
                        'aux_carrinho_promocaos.qtd_promocao',
                        'aux_carrinho_promocaos.obs_pedido',
                        'promocoes.title_promocao',
                        'promocoes.decricao_promocao',
                        'aux_carrinho_promocaos.promocao'
                    ) //DB::raw("COUNT(*) as qtdCarrinho")aux_carrinho_produtos
                    ->join('aux_pedido_carrinhos', 'pedidos_id', '=', 'pedidos.id')
                    ->join('carrinhos', 'carrinhos.id', '=', 'aux_pedido_carrinhos.carrinho_id')
                    ->join('aux_carrinho_promocaos', 'aux_carrinho_promocaos.carrinho_id', '=', 'carrinhos.id')
                    ->join('promocoes', 'promocoes.id', '=', 'aux_carrinho_promocaos.promocao_id')
                    ->where([
                        'pedidos.id' => $orderId,

                    ]);

                $produtosPedido = DB::table('pedidos')
                    ->select(
                        'produtos.id',
                        'aux_carrinho_produtos.valor_total_prod',
                        'aux_carrinho_produtos.qtd_produto',
                        'aux_carrinho_produtos.obs_pedido',
                        'produtos.nome_prod',
                        'produtos.desc_prod',
                        'aux_carrinho_produtos.promocao'
                    ) //DB::raw("COUNT(*) as qtdCarrinho")aux_carrinho_produtos
                    ->join('aux_pedido_carrinhos', 'pedidos_id', '=', 'pedidos.id')
                    ->join('carrinhos', 'carrinhos.id', '=', 'aux_pedido_carrinhos.carrinho_id')
                    ->join('aux_carrinho_produtos', 'aux_carrinho_produtos.carrinho_id', '=', 'carrinhos.id')
                    ->join('produtos', 'produtos.id', '=', 'aux_carrinho_produtos.produto_id')
                    ->where([
                        'pedidos.id' => $orderId,
                    ])
                    ->unionAll($promocaoPedido) //adiconar as promocoes ao carrinho
                //->orderBy('aux_carrinho_produtos.id')
                    ->get();
                   
                    Log::debug($produtosPedido);
                    $produtos = [];

                    foreach ($produtosPedido as $produto):
                        Log::debug("Dados produtos = ");
                        Log::debug($produto->id);

                        $atributosProduto = DB::table('pedidos')
                            ->select(
                                'atributos.nome_atributo','attr_carrinhos.atributo_id', 'attr_carrinhos.atributo_qtd'
                            ) 
                            ->join('aux_pedido_carrinhos', 'pedidos_id', '=', 'pedidos.id')
                            ->join('carrinhos', 'carrinhos.id', '=', 'aux_pedido_carrinhos.carrinho_id')
                            ->join('aux_carrinho_produtos', 'aux_carrinho_produtos.carrinho_id', '=', 'carrinhos.id')
                            ->join('attr_carrinhos', 'aux_carrinho_id', '=', 'aux_carrinho_produtos.id')
                            ->join('atributos', 'atributos.id', '=', 'attr_carrinhos.atributo_id')
                            ->join('produtos', 'produtos.id', '=', 'aux_carrinho_produtos.produto_id')
                            ->where([
                                'pedidos.id' => $orderId,
                                'produtos.id' => $produto->id,
                                'produtos.possui_attr' => 1
                            ])->get();

                            $produto = (array) json_decode(json_encode($produto),true);
                            $produto['listAtributos'] = [];
                            
                            if ($atributosProduto){
                                foreach ($atributosProduto as $atributo):
                                    $atributos = (array) json_decode(json_encode($atributo),true);
                                    array_push($produto['listAtributos'], $atributos);
                                endforeach;
                               
                            }

                            array_push($produtos, $produto);
                    endforeach;

               
                if ($produtos) {
                    Log::debug("Retornado os produtos do pedido ID = " . $orderId);
                    $data = [
                        'pedido_details' => $pedidos[0],
                        'produtos' => $produtos,
                    ];

                    Log::debug(json_encode($data));
                    return response()->json($data);
                }
            }
            Log::debug("Falha ao buscar os pedidos ID = " . $orderId);
            return response()->json(null);
        } catch (Exception $e) {
            Log::debug("Erro ao retornar o pedidos ID = " . $orderId);
            return response()->json(null);
        }
    }

    public function cancelOrder($order_id, $reason_cancellation)
    {

        try{
            date_default_timezone_set('America/Recife');
            $hora_cancelamento  = date('H:i:s');

            $order = Pedidos::find($order_id);
            $order->motivo_cancelamento = $reason_cancellation;
            $order->hora_cancelamento = $hora_cancelamento;
            $order->date_fim = date('Y-m-d');
            $busine = Busine::find($order->busines_id);
            $busineConfig = DB::table('busine_configs')
                            ->where('id', $busine->busine_configs_id)
                            ->get();

            $formasPagamento = FormasPagamentos::find($order->formas_id);
            Log::debug('Forma pagamento: '.$formasPagamento);
            Log::debug("Motivo do cancelamento: ".$reason_cancellation);

            if($formasPagamento->form_payment_code == CASH_PAYMENT_CODE){
                return $this->cancelOrderCash($order, $formasPagamento, $busineConfig);
            }else{
                return $this->cancelOrderCard($order, $formasPagamento, $busineConfig);
            }

        }catch (PagarMeException $e) {
            Log::debug("Error: ".$e->getMessage());
            return response()->json(["success" => false, "message" => $e->getMessage()]);
        }

    }

    /* calcula a diferença de tempo entre o momento em que o pedido foi
    realizado e o tempo em que o usuário está querendo cancelar o pedido */
    function timeDiff( $dateStart, $dateEnd, $format = '%i' ) {
        date_default_timezone_set('America/Sao_Paulo');
        $d1 = new \DateTime($dateStart);
        $d2 = new \DateTime( $dateEnd );

        //Calcula a diferença entre as horas
        $diff = $d1->diff($d2, true);

        //Formata no padrão esperado e retorna
        return $diff->format( $format );

    }

    private function codeGenerate($idUser, $idPedido)
    {
        $variavel = date("i");
        Log::debug($variavel);
        $variavel = strtoupper(str_replace("0", "", $variavel));
        Log::debug($variavel);
        $variavel = \dechex($variavel);

        Log::debug($variavel);

        $codigo = $idPedido . "" . $variavel . "" . $idUser;

        Log::debug("Rand = " . $variavel . " codigo =" . $codigo);

        return $codigo;

    }

    private function cancelOrderCash($order,$formasPagamento, $busineConfig){
        $hora_pedido = $order->hora_inicio;
        $hora_atual =  date('H:i:s');
        $order->hora_cancelamento = $hora_atual;

        $diferença_tempo  = $this->timeDiff($hora_atual, $hora_pedido);

        Log::debug('Hora atual: '.$hora_atual);
        Log::debug('Hora pedido: '.$hora_pedido);
        Log::debug("A diferença é de ".$diferença_tempo.' minutos');

        if($order->status_cancelado  == 0 && $diferença_tempo <= $busineConfig[0]->delivery_time ){

            if($formasPagamento->form_payment_code == CASH_PAYMENT_CODE){
                $order->status_cancelado = 1;
                $order->status = PEDIDO_CANCELADO;
                $order->save();

                if($order){
                    return response()->json([
                        "success" => true,
                        "message" => "Seu pedido foi cancelado com sucesso"
                        ]);
                }
            }


        }else{
            return response()->json([
                "success" => false,
                "message" => "O tempo limite para cancelamento desse pedido se esgotou"
            ]);

            Log::debug("O tempo limite para cancelamento do pedido se esgotou");
        }
    }

    private function cancelOrderCard($order,$formasPagamento, $busineConfig){
        $hora_pedido = $order->hora_inicio;
        $hora_atual =  date('H:i:s');
        $order->hora_cancelamento = $hora_atual;

        $diferença_tempo  = $this->timeDiff($hora_atual, $hora_pedido);

        Log::debug('Hora atual: '.$hora_atual);
        Log::debug('Hora pedido: '.$hora_pedido);
        Log::debug("A diferença é de ".$diferença_tempo.' minutos');

        if($order->status_cancelado  == 0 && $diferença_tempo <= $busineConfig[0]->delivery_time ){
            $pagarme = new PagarMe\Client('ak_test_hDQZyhCpKbvW36dLsnHvnybS5eBOtG');
            $refundedTransaction = $pagarme->transactions()->refund([
                'id' => $formasPagamento->transaction_id,
            ]);

            Log::debug($refundedTransaction->status);
            if($refundedTransaction->status == 'refunded'){

                $order->status_cancelado = 1;
                $order->status = PEDIDO_CANCELADO;
                $order->save();

                if($order){
                    return response()->json([
                        "success" => true,
                        "message" => "Seu pedido foi cancelado com sucesso"
                        ]);
                }

            }


        }else{
            return response()->json([
                "success" => false,
                "message" => "O tempo limite para cancelamento desse pedido se esgotou"
            ]);

            Log::debug("O tempo limite para cancelamento do pedido se esgotou");
        }
    }
}
