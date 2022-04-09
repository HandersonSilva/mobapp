<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\SendMailAdmin;
use execption;
use Log;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dash';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {        
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:100|unique:admins',
            'password' => 'required|string|min:6|confirmed',
            'cpf'=>'required|string|min:14|max:18|unique:admins',
            'telefone'=>'required|string|min:15|',
        ],
        [
            'required' => 'O campo :attribute é obrigatório',
            'email' => 'O email :input não é válido',
            'unique'=>':attribute  já existente na base de dados',
            'password.min'=>'O campo senha não pode conter menos de 6 caracteres',
            'password.confirmed'=>'As senhas não conferem',
            'cpf.min'=>'O documento não pode conter menos de 11 caracteres',
            'cpf.max'=>'O documento não pode conter mais de 18 caracteres',
            'telefone.min'=>'O campo :attribute não pode conter menos de 11 caracteres',
            'name.max' => 'O limite máximo de carateres para o campo nome é de 100',
            'name.required' => 'O campo nome é obrigatório.'
        ]);
 
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Admin
     */
    protected function create(array $data)
    {
        
        $admin = Admin::where('email', '=', $data['email'])->count();
        if($admin > 0){
            Log::debug('usuario encontrado'.$admin);
            return false;
            
        }else{

            do{
               $hash = preg_replace('{^/?([^\?]+)\?.*$}','$1',Hash::make($data['name'].'_'.$data['email'].'_'.preg_replace('/[^0-9]/','',$data['cpf'])));
               $hashValido = strripos($hash, '/');
            }while($hashValido);
            
            try{
                Log::debug('salvando admin');
                $admin = Admin::create([
                    'nome' => $data['name'],
                    'email' => $data['email'],
                    'cpf' => preg_replace('/[^0-9]/','',$data['cpf']),
                    'telefone' => preg_replace('/[^0-9]/','',$data['telefone']),
                    'password' => Hash::make($data['password']),
                    'hash_activate' => $hash
                ]);
                
                if($admin){
                    $sendMailUser = new SendMailAdmin($admin);
                    $response = $sendMailUser->sendMailActivate(array(
                        'fromEmail' => 'pidadelivery@pida.com',
                        'subject' => 'Ativação de Conta',
                        'content' => '',
                        'name' => 'Pida Delivery'
                    ));
    
                }
                //return redirect('dash');
            }catch(Exception $e){
                throw new QueryException();
                return $admin = null;
            }
          

            return $admin;
        }
    }
  
      
}
