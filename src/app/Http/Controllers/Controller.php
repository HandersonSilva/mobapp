<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function  __construct(){
        auth()->setDefaultDriver('web');

   /*try {
            $user =  auth()->userOrFail();
            Log::debug("User ".$user->email." Autenticando");
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            Log::debug("Autenticação falhou para salvar o item do carrinho...Error = ".$e->getMessage());
            return response()->json(["mensagem"=>"Erro ao realizar login"],400);
          
        }*/
      } 

}   
