<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Exceptions\Handler;
use PagarMe\Exceptions\PagarMeException;
use Illuminate\Http\Request;
use App\Models\Cartao;
use App\Models\User;
use PagarMe;

use Log;

class CartaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $cartoes = Cartao::all();
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

        $data_card = $request->all();

        // Log::debug($data_card);
        // die();

         //salvando o cartao do usuario
        $date = str_replace('/', '-', $data_card['card_expiration'] );

        $data_card['card_expiration'] = $date;

        // Log::debug($data_card['card_number']);
        // die();

        $cardExist = Cartao::where('card_number', $data_card['card_number'])->get();

        Log::debug(count($cardExist));

        if(count($cardExist) <= 0 ):
            Log::debug('Cartao nao encontrado');

            $verifyCardInApi = $this->verifyCard($data_card);

            if(!empty($verifyCardInApi) && $verifyCardInApi->valid){
                $cartao = Cartao::create($data_card);

                if($cartao):
                    return response()->json([$cartao, "status" => 0]);
                else:
                    return response()->json([
                        "message" => "Erro ao salvar cartão",
                        "status" => 1
                        ]);
                endif;

            }else{
                return response()->json([
                    "message" => "Cartão inválido",
                    "status" => 1
                    ]);
            }

        else:
            return response()->json([
                "message" => "O cartão já está salvo",
                "status" => 1
                ]);
        endif;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)//passa-se o id do usuario para que seja retornado todos os seus cartoes
    {
        $user = User::find($id);

        if($user)
        {
            $cartoes = $user->cartoes()->get();

            return response()->json($cartoes);
        }else
        {
            response()->json([]);
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
        $cartao = Cartao::find($id);

        $delete_card = $cartao->delete();
        $response = null;

        if($delete_card):
            $response = true;
        else:
            $response = false;
        endif;

        return response()->json(["retorno" => $response]);
    }

    private function verifyCard($data_card = array()){
        Log::debug($data_card);
        $card = null;
        $pagarme = new PagarMe\Client('ak_test_hDQZyhCpKbvW36dLsnHvnybS5eBOtG');

        try{

            $card = $pagarme->cards()->create([
                'holder_name' => $data_card['card_name'],
                'number' => base64_decode($data_card['card_number']),
                'expiration_date' => str_replace('-', '', $data_card['card_expiration']),
                'cvv' => $data_card['csv']
            ]);

            return $card;

        }catch(PagarMeException $e){
            Log::error($e->getMessage());
        }

        return [];

    }
}
