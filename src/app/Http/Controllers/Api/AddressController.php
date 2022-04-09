<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Log;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = $request->all();

        // Log::debug( $data );
        // die();

        $address = Address::create($data);

        if ($address) :
            $user = $address->user()->get();

            $data = array(
                "id" => $user[0]->id,
                "nome" => $user[0]->nome,
                "email" => $user[0]->email,
                "cpf" => $user[0]->cpf,
                "url_img_perfil" => $user[0]->url_img_perfil,
                "hash_google" => $user[0]->hash_google,
                "telefone" => $user[0]->telefone,
                "address" => [
                    "id" => $address->id,
                    "cidade" => $address->cidade,
                    "UF" => $address->UF,
                    "bairro" => $address->bairro,
                    "rua" => $address->rua,
                    "cep" => $address->cep,
                    "numero" => $address->numero,
                    "lat_user" => $address->lat_user,
                    "log_user" => $address->log_user,
                    "user_id" => $address->user_id
                ],
                "status" => true,
            );

            Log::debug("Endereco cadastrado");

            return response()->json($data);

        else :

            $retorno = array(
                'data' => $address,
                'status' => Response::HTTP_NOT_FOUND
            );
            return response()->json($retorno);

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

        Log::debug('Atualizando endereço do usuário');
        try {
            auth()->userOrFail();

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            Log::debug('Erro ao atualizar o endereço do usuario com id '.$id);
            return response()->json(['error' => $e->getMessage()], 401);
        }
            $address = Address::where("user_id", $id);
            $address->update($request->all());


            if ($address) {
                $addresUpdate = Address::where("user_id", $id)->get();
                Log::debug("Endereço atualizado");
                Log::debug($addresUpdate);

                return response()->json(["success" => true, "message" => "Endereço do usuário foi atualizado."]);
            } else {
                return response()->json(["success" => false, "message" => "Erro na atualização do endereço."]);
            }
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
