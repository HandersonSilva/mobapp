<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Log;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function  __construct(){
      auth()->setDefaultDriver('api');
    } 

    /*public function authUserApi($retorno = null){
        try {
          $user = auth()->userOrFail();
          Log::debug("User ".$user->email." Autenticado");
      } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
          Log::debug("Autenticação falhou Error = ".$e->getMessage());
          return response()->json($retorno,401);
      }
    }*/
}
