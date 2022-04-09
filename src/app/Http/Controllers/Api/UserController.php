<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\AddressLocalUser;
use App\Models\User;
use App\Util\GetApi;
use Illuminate\Http\Request;
use App\Mail\SendMailUser;
use Exception;
use Log;
use Illuminate\Support\Facades\Storage;
use JWTAuth;


class UserController extends Controller
{

    /**
     * @var JWTAuth
     */
   /* private $jwtAuth;
    public function __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {

            auth()->userOrFail();
             //
            //recuperando arquivo do banco
            $usuarios = User::all();

            $retorno = (count($usuarios) > 0) ? $usuarios : false;
            return response()->json( $retorno );

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()],401);
        }

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
        //cadastrar novo usuario
        $dados = $request->all();
        
        $senha = $dados['password'];
        $custo = '08';
        $salt = 'Cf1f11ePArKlBJomM0F6aJ';
        
        // Log::debug($dados);
        // die();

        if (!User::where('email', $dados['email'])->count()) {

            $dados['password'] = crypt($senha, '$2a$' . $custo . '$' . $salt . '$');
            $user = User::create($dados);

            // Log::debug('User salvo'.$user);
            return response()->json($user);

        } else {
            return response()->json(['message' => 'Este e-mail já está cadastrado.'], 400);
        }
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

    //verifica usuario
    public function getUser($email, $password)
    {
        $data = null;
        $credentials = array(
            "email" => $email,
            "password"=>$password,
        );

        Log::debug("Usuario ".$email." realizando login");

        if (!$token = auth()->attempt($credentials)) {
            Log::debug("Usuario ".$email." nao autorizado");
            $data = array(
                "id" => null,
                "nome" => null,
                "email" => null,
                "cpf" => null,
                "url_img_perfil" => null,
                "hash_google" => null,
                "telefone" => null,
                "activate_account" => null,
                "distancia" => null,
                "status" => $token,
                "token" => 403

            );
           return response()->json($data, 403);
        }
        // return response()->json($token);
        // $password = $this->cryptSenha($password);
        $user = auth()->authenticate($token);
        Log::debug("Usuario ".$user->nome." autorizado");
        try{
            $user_find = User::find($user->id);
            $address = $user_find->address()->get();

            Log::debug($user_find);

            if($user_find->activate_account == 1){
                //return $address;
                $data = array(
                    "id" => $user->id,
                    "nome" => $user->nome,
                    "email" => $user->email,
                    "cpf" => $user->cpf,
                    "password" => $user->password,
                    "url_img_perfil" => $user->url_img_perfil,
                    "hash_google" => $user->hash_google,
                    "telefone" => $user->telefone,
                    "activate_account" => true,
                    "distancia" => $user->distancia,
                    "address" => [
                        "id" => $address[0]->id,
                        "cidade" => $address[0]->cidade,
                        "UF" => $address[0]->UF,
                        "bairro" => $address[0]->bairro,
                        "rua" => $address[0]->rua,
                        "cep" => $address[0]->cep,
                        "numero" => $address[0]->numero,
                        "lat_user" => $address[0]->lat_user,
                        "log_user" => $address[0]->log_user,
                        "user_id" => $address[0]->user_id,
                    ],
                    "status" => true,
                    "token"=>$token

                );

            }else{
                $data = array(
                    "id" => $user->id,
                    "nome" => $user->nome,
                    "email" => $user->email,
                    "cpf" => $user->cpf,
                    "password" => $user->password,
                    "url_img_perfil" => $user->url_img_perfil,
                    "hash_google" => $user->hash_google,
                    "telefone" => $user->telefone,
                    "activate_account" => false,
                    "distancia" => $user->distancia,
                    "address" => [
                        "id" => $address[0]->id,
                        "cidade" => $address[0]->cidade,
                        "UF" => $address[0]->UF,
                        "bairro" => $address[0]->bairro,
                        "rua" => $address[0]->rua,
                        "cep" => $address[0]->cep,
                        "numero" => $address[0]->numero,
                        "lat_user" => $address[0]->lat_user,
                        "log_user" => $address[0]->log_user,
                        "user_id" => $address[0]->user_id,
                    ],
                    "status" => true,
                    "token"=>$token

                );
            }

            Log::debug("usuario ".$user->nome." conectou-se");
            return response()->json($data, 200);

        }catch(Esception $e){
            Log::debug("Error ao realizar o login error = ".$e->getMessage());
            $data = array(
                "id" => null,
                "nome" => null,
                "email" => null,
                "cpf" => null,
                "url_img_perfil" => null,
                "hash_google" => null,
                "telefone" => null,
                "distancia" => null,
                "activate_account" => false,
                "address" => null,
                "status" => false,
                "token" => 403

            );
           return response()->json($data);
        }
    }

    public function refreshTokenJwt(){
        Log::debug("Gerando o refresh");
        $newToken = '';
         try{
              $token = auth()->getToken();
            if(!$token){
                Log::debug("Token não encontrado no header da aplicação");
                //throw new BadRequestHtttpException('Token not provided');
            }
            $newToken = auth()->refresh($token);

        }catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            Log::debug("Erro ao atualizar o token = ".$e->getMessage());
            return response()->json(["status"=>false,"token"=>$newToken],401);
        }
        Log::debug("New token = ".$newToken);
        return response()->json(["status"=>true,"token"=>$newToken]);
    }

    public function logoutTokenJwt(){
       auth()->logout(true);
       return response()->json(["status"=> "Token invalidado"]);
    }

    public function getUserGoogle($hash, $email)
    {

        $credentials = array(
            "email" => $email,
            "password"=>$hash,
        );

        Log::debug("Usuario ".$email." realizando login");

        if (!$token = auth()->attempt($credentials)) {
            Log::debug("Usuario ".$email." nao autorizado");
            $data = array(
                "id" => null,
                "nome" => null,
                "email" => null,
                "cpf" => null,
                "url_img_perfil" => null,
                "hash_google" => null,
                "telefone" => null,
                "distancia" => null,
                "status" => $token,
                "token" =>403

            );
           return response()->json($data);
        }

        $user = auth()->authenticate($token);
        Log::debug("Usuario ".$user->nome." autorizado");
        try{
            $user_find = User::find($user->id);
            $address = $user_find->address()->get();
            //return $address;
            $data = array(
                "id" => $user->id,
                "nome" => $user->nome,
                "email" => $user->email,
                "cpf" => $user->cpf,
                "url_img_perfil" => $user->url_img_perfil,
                "hash_google" => $user->hash_google,
                "telefone" => $user->telefone,
                "distancia" => $user->distancia,
                "address" => [
                    "id" => $address[0]->id,
                    "cidade" => $address[0]->cidade,
                    "UF" => $address[0]->UF,
                    "bairro" => $address[0]->bairro,
                    "rua" => $address[0]->rua,
                    "cep" => $address[0]->cep,
                    "numero" => $address[0]->numero,
                    "lat_user" => $address[0]->lat_user,
                    "log_user" => $address[0]->log_user,
                    "user_id" => $address[0]->user_id,
                ],
                "status" => true,
                "token"=>$token

            );

            Log::debug("usuario ".$user->nome." conectou-se");
            return response()->json($data);

        }catch(Esception $e){
            Log::debug("Error ao realizar o login error = ".$e->getMessage());
            $data = array(
                "id" => null,
                "nome" => null,
                "email" => null,
                "cpf" => null,
                "url_img_perfil" => null,
                "hash_google" => null,
                "telefone" => null,
                "distancia" => null,
                "address" => null,
                "status" => false,
                "token" =>403

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
        Log::debug('Atualizando usuário');
        try {
            auth()->userOrFail();

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            Log::debug('Erro ao atualizar o usuario com id '.$id);
            return response()->json(['error' => $e->getMessage()], 401);
        }
        Log::debug($request->all());

        $user_update = User::find($id);
        $update = $user_update->update($request->all());

        if($update):
            $user_update->activate_account = ($user_update->activate_account == 1) ? true : false;
            return response()->json($user_update, 200);
        else:
            return response()->json(['message' => 'Este e-mail já está cadastrado.'], 400);
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
        //
    }

    public function getEnderecoLocal(Request $request)
    {
        //pegando o endereco do usuario pela posição e salvando no banco
        $userId = isset($request['user_id']) ? $request['user_id'] : null;
        $lat = isset($request['lat']) ? $request['lat'] : null;
        $long = isset($request['lng']) ? $request['lng'] : null;

        if ($userId != null && $lat != null && $long != null) {
            $getApi = new GetApi();
            $enderecoLocal = $getApi->getEnderecoUser($lat, $long);

            if ($enderecoLocal->status == "OK") {
                $enderecoLocal = $enderecoLocal->results;
                $retorno = $enderecoLocal[0]->address_components;
                $geometry = $enderecoLocal[0]->geometry;

                $num = null;
                $rua_long = null;
                $rua_short = null;
                $bairro_long = null;
                $bairro_short = null;
                $cidade_long = null;
                $cidade_short = null;
                $estado_long = null;
                $estado_short = null;
                $pais_long = null;
                $pais_short = null;
                $cep_long = null;
                $endereco_format = null;
                $lat = null;
                $long = null;
                foreach ($retorno as $dado) {

                    if ($dado->types[0] == "street_number") {
                        $num = $dado->long_name;
                    }
                    if ($dado->types[0] == "route") {
                        $rua_long = $dado->long_name;
                        $rua_short = $dado->short_name;
                    }
                    if ($dado->types[0] == "political") {
                        $bairro_long = $dado->long_name;
                        $bairro_short = $dado->short_name;
                    }
                    if ($dado->types[0] == "administrative_area_level_2") {
                        $cidade_long = $dado->long_name;
                        $cidade_short = $dado->short_name;
                    }
                    if ($dado->types[0] == "administrative_area_level_1") {
                        $estado_long = $dado->long_name;
                        $estado_short = $dado->short_name;
                    }
                    if ($dado->types[0] == "country") {
                        $pais_long = $dado->long_name;
                        $pais_short = $dado->short_name;
                    }
                    if ($dado->types[0] == "postal_code") {
                        $cep_long = $dado->long_name;
                    }

                }
                $data = [

                    "user_id" => $userId,
                    "num" => $num,
                    "rua_long" => $rua_long,
                    "rua_short" => $rua_short,
                    "bairro_long" => $bairro_long,
                    "bairro_short" => $bairro_short,
                    "cidade_long" => $cidade_long,
                    "cidade_short" => $cidade_short,
                    "estado_long" => $estado_long,
                    "estado_short" => $estado_short,
                    "pais_long" => $pais_long,
                    "pais_short" => $pais_short,
                    "cep_long" => $cep_long,
                    "endereco_format" => $enderecoLocal[0]->formatted_address,
                    "lat" => $geometry->location->lat,
                    "lng" => $geometry->location->lng,

                ];
                try {
                    $enderecoLocal = AddressLocalUser::create($data);
                    return response()->json($enderecoLocal);
                } catch (Exception $e) {
                    $data = null;
                    return response()->json($data);
                }

            } else {
                $data = null;
                return response()->json($data);
            }

        } else {
            $data = null;
            return response()->json($data);
        }

    } // "address_components": [']

    public function cryptSenha($password){
        $senha = $password;
        $custo = '08';
        $salt = 'Cf1f11ePArKlBJomM0F6aJ';

        $senha = crypt($senha,'$2a$'.$custo . '$' . $salt . '$');
        return $senha;
    }

    public function redefinirSenha($email){

        $user = User::where('email', $email)->get();
        // $user = User::find(5);
        // Log::debug($user[0]);die();

        Log::debug("Enviando email");

        if (!isset($user[0])){
            return response()->json(["success" => false, "message" => "Não foi encontrado nenhum usuário com o email digitado."]);
        }

        Log::debug("Enviando email para ".$user[0]->nome);

        $sendMailUser = new SendMailUser($user[0]);
        $response = $sendMailUser->sendMail();

        if($response){
            return response()->json(["success" => true, "message" => "Email enviado para ".$email]);
        }

        return response()->json(["success" => false, "message" => "Não foi possivel enviar o email para ".$email]);


    }

    public function newPassword(Request $request){
        $req = $request->all();

        $senha = $req['newPassword'];
        $custo = '08';
        $salt = 'Cf1f11ePArKlBJomM0F6aJ';

        $user = User::find($req['id']);

        try {

            if($user){
                Log::debug($user->code_expires);
                if($user->code_expires == $req['code']){
                    Log::debug("Ok o codigo é valido");

                    $user->password = crypt($senha, '$2a$' . $custo . '$' . $salt . '$');
                    $user_save = $user->save();

                    if($user_save){
                        return response()->json(["success" => true, "message" => "Senha redefinida com sucesso"]);
                    }

                }else{
                    return response()->json(["success" => false, "message" => "O código é inválido"]);
                }
            }else{
                return response()->json(["success" => false, "message" => "Usuário inválido"]);
            }
        } catch (Exception $e) {
            return response()->json(["success" => false, "message" => "Ocorreu um erro ".$e->getMessage()]);
        }

    }

    public function sendCodeActivation($email){
        $sendMailUser = null;
        $user = User::where('email', $email)->get();
        // $user = User::find(5);
        // Log::debug($user[0]);die();
       
        Log::debug("Enviando codigo de ativação para o email");
        
        if (!isset($user[0])){
            return response()->json(["success" => false, "message" => "Não foi encontrado nenhum usuário com o email digitado."]);
        }else if(isset($user[0]) && $user[0]->hash_google == null) {
            $sendMailUser = new SendMailUser($user[0]);
            $response = $sendMailUser->sendMail(array(
                'fromEmail' => 'franciscoalves@gmail.com',
                'subject' => 'Código de ativação',
                'content' => '<p>Seu código de ativação é <b>$code</b></p>',
                'name' => 'Pida Delivery',
                'to' => $user[0]->email,
                'activation' => true
            ));
            
            if($response){
                return response()->json(["success" => true, "message" => "Email enviado para ".$email],200);
            }
    
            return response()->json(["success" => false, "message" => "Não foi possivel enviar o email para ".$email],400);

        }else{
            $sendMailUser = new SendMailUser($user[0]);
            $response = $sendMailUser->sendMail(array(
                'fromEmail' => 'franciscoalves@gmail.com',
                'subject' => 'Bem-vindo(a) ao Pida Delivery',
                'content' => '<p>Olá <b>$usuario</b></p><p>Seja bem vindo(a) ao Pida Delivery, seu cadastro foi realizado com êxito em nossa plataforma.</p>',
                'name' => 'Pida Delivery',
                'to' => $user[0]->email,
                'activation' => false
            ));
            
            if($response){
                return response()->json(["success" => true, "message" => "Email enviado para ".$email],200);
            }
        }
      
        return response()->json(["success" => false, "message" => "Não foi possivel enviar o email para ".$email],400);

    }

    public function activateAccount(Request $request){
        $user = User::find($request['id']);

        Log::debug($request->all());
        Log::debug($user);

        if($user){
            try {
                if($user->activate_account == 0 && $user->code_expires == $request['code']){
                    $user->activate_account = 1;
                    $user->save();

                    return response()->json(["success" => true, "message" => "Sua conta foi validada."]);
                }else{
                    return response()->json(["success" => false, "message" => "Não foi possível validar esse usuário."]);
                }

            } catch (\Throwable $th) {
                return response()->json(["success" => false, "message" => "Erro na requisição, erro: ".$th->getMessage() ]);
            }
        }else{
            return response()->json(["success" => false, "message" => "Usuário inválido."]);
        }
    }

    public function updateImgUser(Request $request){
        \define('USER_PATH_PROFILE', 'users/profile/');
        define('EMPRESA_PATH_LOGO', 'empresas/logo/');

        $token = $request['token'];
        $img = $request['img'];
        $salt = 'Cf1f11ePA';

        try {
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();
            Log::debug($user);
           // Log::debug("user atual ".$user);

        }catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            Log::debug('Erro ao atualizar o usuario com id ');
            return response()->json(['error' => $e->getMessage()], 401);

        }

        // Log::debug("Removendo a imagem ". $user->url_img_perfil);
        if($user->url_img_perfil != null){
            if($user->url_img_perfil != "img_padrao.png"){
                Storage::disk('public')->delete(USER_PATH_PROFILE.$user->url_img_perfil);
            }
        }

        $image = base64_decode($img);
        $time = time();
        //$safeName = str_random(10).'.'.'png';
        $userCrypt = crypt($user->nome, $salt);
        $safeName =  $time."_".$userCrypt.'.'.'png';
        Storage::disk('public')->put(USER_PATH_PROFILE.$safeName, $image);

        $user_update = User::find($user->id);
        $user_update->url_img_perfil = $safeName;

      if($user_update->save()){
        return response()->json(["success" => true, "message" => $safeName]);
        Log::debug("Atualizando imagem de perfil para o usuario ".$user->id);
      }else{
        Log::debug("Error ao Atualizar imagem de perfil para o usuario ".$user->id);
      }
       //$url = Storage::url($safeName);
       return response()->json(["success" => false, "message" => "img_padrao.png"]);

    }
}
