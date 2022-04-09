<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use App\Mail\SendMail;
use App\Mail\SiteSendEmailContact;
use Illuminate\Support\Facades\Mail;
use Log;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {


        return view('dash');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmailSite(Request $request)
    {
        $data = $request->all();

        \Log::info($data);
        try{
            Mail::to(getenv('EMAILS_ADMIN'))
            ->send(new SiteSendEmailContact($data));
            return response()->json(["status"=> 200],200);
        }catch(\Exception $e){
            \Log::info($e->getMessage());
            return response()->json(["status"=> 400],400);
        }

        // $sendMail= new SendMail();
        // $response = $sendMail->sendMail(array(
        //     'fromEmail' => 'admin@mobsystem.com.br',
        //     'subject' => 'Novo Cliente no Site!!!',
        //     'content' =>'<p><b>Dados para contato: </b></p>
        //                 <p>Nome: <b>'.$data["nome"].'</b></p>
        //                 <p>Telefone: <b>'.$data["telefone"].'</b></p>
        //                 <p>Email: <b>'.$data["email"].'</b></p>
        //                 <p>Mensagem: <b>'.$data["mensagem"].'</b></p>
        //                 ',
        //     'name' => 'MobSystem',
        //     'to' => getenv('EMAILS_ADMIN'),
        // ));
    }
}
