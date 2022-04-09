<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\SendMailAdmin;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\DB;
use Validator;

class AdminController extends Controller
{

     /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(["mensagem"=>"Acessado"],400);
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

        $validator = Validator::make($request->all(), [
           'name' => 'required|string|max:60',
           'email' => 'required|email',
           'password' => 'required|string|min:6|confirmed',
           'telefone' => 'required|string|max:255',
        ],
            [
                'required' => 'O campo :attribute é obrigatório',
                'password.min' => 'O campo senha não pode conter menos de 6 caracteres',

            ]);


        if ($validator->fails())
        {
            return response()->json(['mensagem' => 'Dados inválido'],400);
        }

        $adminExiste = Admin::where('email', '=', $data['email'])->count();
        if($adminExiste > 0){
            Log::debug('usuario encontrado'.$adminExiste);
            return response()->json(["mensagem"=>"Conta já existente"],409);
        }

        do{
            $hash = preg_replace('{^/?([^\?]+)\?.*$}','$1',Hash::make($data['name'].'_'.$data['email']));
            $hashValido = strripos($hash, '/');
        }while($hashValido);

        try{
            Log::debug('salvando admin');
            $adminCreate = Admin::create([
                'nome' => $data['name'],
                'email' => $data['email'],
                'telefone' => preg_replace('/[^0-9]/','',$data['telefone']),
                'password' => Hash::make($data['password']),
                'hash_activate' => $hash
            ]);

            if($adminCreate){
                $sendMailUser = new SendMailAdmin($adminCreate);
                $response = $sendMailUser->sendMailActivate(array(
                    'fromEmail' => 'pidadelivery@pida.com',
                    'subject' => 'Ativação de Conta',
                    'content' => '',
                    'name' => 'Pida Delivery'
                ));
            }

            return response()->json(["mensagem"=>"Usuário cadastrado com sucesso"],201);
        }catch(Exception $e){
            return response()->json(["mensagem"=>"Error ao salvar o usuário"],400);
        }

        return response()->json(["mensagem"=>"Error ao realizar cadastro"],400);

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

    public function resetSenha(Request $request)
    {
        $data = $request->all();

        $user = Admin::where('email', $data['email'])->get();

        Log::debug("Enviando email");

        if (!isset($user[0])) {
            return response()->json(['mensagem'=>'Email inválido'],400);
        }

        $sendMailUser = new SendMailAdmin($user[0]);
        $response = $sendMailUser->sendMail();

        if ($response == 'true') {
            return response()->json(['mensagem'=>'Enviamos um código de validação para o email ' . $user[0]->email . ' '],200);
        }

        return response()->json(['mensagem'=>'Email inválido'],400);
    }

    public function saveNovaSenha(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ],
            [
                'required' => 'O campo :attribute é obrigatório',
                'password.min' => 'O campo senha não pode conter menos de 6 caracteres',
                'password.confirmed' => 'As senhas não conferem',
            ]);

          
        if ($validator->fails()) {
            return response()->json(['mensagem' => 'Dados inválido'],400);
        }

        $senha = $data['password'];

        $user = Admin::where('email', '=', $data['email_user'])->get();

        try {

            if ($user[0]) {
                Log::debug($user[0]->code_expires);
                if ($user[0]->code_expires == $data['code']) {
                    Log::debug("Ok o codigo é valido");

                    $user[0]->password = Hash::make($data['password']);
                    $user[0]->code_expires = null;
                    $user_save = $user[0]->save();

                    if ($user_save) {
                        return response()->json(['mensagem' => 'Senha redefinida com sucesso'],200);
                    }

                }
                return response()->json(['mensagem' => 'Falha ao redefinir senha, código inválido'],400);

            }
            return response()->json(['mensagem' => 'Usuário inválido'],400);

        } catch (Exception $e) {
            return response()->json(['mensagem' => 'Ocorreu um erro ao validar o código, por favor tente mais tarde...'],200);
        }
    }

    public function ativarConta(Request $request)
    {
        $data = $request->all();
     
        $admin = Admin::where('hash_activate', '=', $data['hash'])->get();
        //return response()->json($admin);
        if (isset($admin[0]->id)) {
            if ($admin[0]->activate_account === 1) {
                return response()->json(["mensagem"=>"Conta ativa, por favor realize o login"],401);
            }

            $admin = Admin::find($admin[0]->id);
            $admin->activate_account = 1;
            $admin->save();

            return response()->json(["mensagem"=>"Conta ativada com sucesso"],200);

       } else {
        return response()->json(["mensagem"=>"Não foi possível ativar sua conta, Por favor entre em contato com os administradores do sistema"],401);
       }
    }

    protected function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            "email.required" => "O email é obrigatório",
            "password.required" => "A senha é obrigatória",
            "password.min" => "A senha requer no mínimo 6 carateres",
            "email" => "Formato de email incorreto",
        ]);

        if ($validator->fails()) {
            return response()->json(["mensagem"=>"Senha ou email incorreto"],400);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
         
            $user = Auth::user();
          
            $admin = [
                "id" => $user->id,
                "nome" => $user->nome,
                "email" => $user->email,
                "url_img_perfil" => $user->url_img_perfil,
                "activate_account" => $user->activate_account,
                "empresa" => [],
            ];

            if ($user->activate_account == 0) {
                return response()->json(["mensagem"=>"Conta inativa, por favor verifique seu email para ativa sua conta","data"=> $admin],200);
            }

            $busine = DB::table('busines')
            ->select(
                'busines.id',
                'busines.nome_fantasia',
                'busines.telefone',
                'seguimento',
                'url_img_busine',
                'docs',
                'busine_configs.status_openCloser',
                'busine_configs.valor_frete',
                'busine_enderecos.lat_empresa',
                'busine_enderecos.log_empresa'
              
            )
            ->leftjoin('busine_configs', 'busine_configs.id', '=', 'busines.busine_configs_id')
            ->leftjoin('admins', 'admins.id', '=', 'busines.admin_id')
            ->leftjoin('busine_enderecos', 'busine_enderecos.id', '=', 'busines.busine_enderecos_id')
            ->where('busines.admin_id', '=',$user->id)
            ->get()->toArray();

            $admin['empresa'] = $busine ? $busine[0] : [];

            return response()->json(["mensagem"=>"Login realizado com sucesso","data"=> $admin],200);
        }

        return response()->json(["mensagem"=>"Erro ao realizar login, email ou senha inválido"],400);
    }

    public function logout(){
        Auth::logout();

        return response()->json(['mensagem' =>"Usuario deslogado"],200);
    }

    public function envioLinkAtivacao(Request $request)
    {
        $data = $request->all();

        if (empty($data['email'])){
           return response()->json(["mensagem"=>"Email do usuário inválido"],400);
        }

        $admin = Admin::where('email', '=', $data['email'])->get();

        if ($admin) {
            if ($admin[0]->activate_account === 1) {
                return response()->json(["mensagem"=>"Conta ativa, por favor realize o login"],409);
            }

            if (isset($data['email'])) {

                $sendMailUser = new SendMailAdmin($admin[0]);
                $response = $sendMailUser->reenvioMailActivate(array(
                    'fromEmail' => 'pidadelivery@pida.com',
                    'subject' => 'Ativação de  Conta',
                    'to' => $data['email'],
                    'hash' => $admin[0]->hash_activate,
                    'content' => '',
                    'name' => 'Pida Delivery',
                ));

                if ($response == 'true') {
                    return response()->json(['mensagem' => 'Enviamos um link de ativação para o email ' . $data['email']],200);
                }
                return response()->json(['mensagem' => 'Não foi possível enviar o email de ativação'],400);
            }

        }
    }
}
