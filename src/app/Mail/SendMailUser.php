<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use Log;
use SendGrid\Mail\Mail;


class SendMailUser
{
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public function __construct(User $user)
     {
         $this->user = $user;
     }

    // public static function withObject(  ) {
    //     $instance = new self();
    //     $instance->user = $user;
    //     return $instance;
    // }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function sendMail($options=[])
    {
        date_default_timezone_set('America/Recife');
        $code = $this->generateCode();
        $saved_code = date('H:i:s');

        if(isset($options['activation'])){
            if(isset($this->user) && $options['activation']){
                $this->user->code_expires = $code;
                $this->user->saved_code = $saved_code;
                $this->user->save();
            }
        }
        
        $mail = new Mail();  
        if(!empty($options)){
            $mail->setFrom($options['fromEmail'], 'Pida Delivery');
            $mail->setSubject($options['subject']);
            // $mail->addTo($this->user->email, $options['name']);
            $mail->addTo($options['to'], 'Pida Delivery');
            if($options['activation']){
                $mail->addContent("text/html", str_replace('$code', $code, $options['content']));

            }else{
                $mail->addContent("text/html", str_replace('$usuario', $this->user->nome, $options['content']));
            }


        }else{

            $mail->setFrom('atendimento@pida-delivery.com', 'Pida Delivery');
            $mail->setSubject("Redefinição de senha");
            $mail->addTo($this->user->email, 'Pida Delivery');
            $mail->addContent(
                "text/html", "<strong style='font-size:18px;'>".$code."</strong> Esse é seu código para usar no app e redefinir sua senha."
            );
        }
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($mail);
            if($response){
                return response()->json(["success" => true, "message" => "Email enviado para ".$this->user->email]);
            }else{
                return response()->json(["success" => false, "message" => "Erro no envio do email"]);
            }
        } catch (Exception $e) {
             Log::debug("Erro no envio do email ".$e->getMessage());
            return response()->json(["success" => true, "message" => "Erro no envio do email ".$e->getMessage()]);
        }

    }

    private function generateCode(){

        $code = round(microtime(true) * 1000);
        $code = substr($code, -6);

        return $code;
    }
}
