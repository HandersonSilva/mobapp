<?php

namespace App\Mail;

use App\Models\Admin;
use Log;
use SendGrid\Mail\Mail;

class SendMailAdmin
{
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(Admin $user)
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
    public function sendMail($options = [])
    {
        date_default_timezone_set('America/Recife');
        $code = $this->generateCode();
        $saved_code = date('H:i:s');

        if (isset($this->user)) {
            $this->user->code_expires = $code;
            $this->user->saved_code = $saved_code;
            $this->user->save();
        }

        Log::debug($options);
        $mail = new Mail();
        if (!empty($options)) {
            Log::debug($options['fromEmail']);
            Log::debug($this->user->email);
            if ($this->user == null) {
                $mail->addTo($options['to'], $options['name']);
            } else {
                $mail->addTo($this->user->email, $options['name']);
            }

            $mail->setFrom($options['fromEmail'], 'Pida Delivery');
            $mail->setSubject($options['subject']);
            $mail->addContent("text/html", str_replace('$code', $code, $options['content']));

        } else {

            $mail->setFrom('pidadelivery@pida.com', 'Pida Delivery');
            $mail->setSubject("Redefinição de senha");
            $mail->addTo($this->user->email, 'Pida Delivery');
            $mail->addContent(
                "text/html", "<strong style='font-size:18px;'>" . $code . "</strong> Esse é seu código para usar no app e redefinir sua senha."
            );
        }

        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($mail);

            if ($response) {
                return 'true'; //response()->json(["success" => true, "message" => "Email enviado para ".$this->user->email]);
            } else {
                return 'false'; //response()->json(["success" => false, "message" => "Erro no envio do email"]);
            }
        } catch (Exception $e) {
            return 'false'; //response()->json(["success" => true, "message" => "Erro no envio do email ".$e->getMessage()]);
        }

    }

    public function sendMailActivate($options = [])
    {

        $mail = new Mail();
        if (!empty($options)) {

            if ($this->user == null) {
                $mail->addTo($options['to'], $options['name']);
            } else {
                $mail->addTo($this->user->email, $options['name']);
            }

            $mail->setFrom($options['fromEmail'], 'Pida Delivery');
            $mail->setSubject($options['subject']);
            $mail->addContent("text/html", "<a href=" . urldecode(getenv('APP_URL_FRONT')) . "/login/ativar_conta/"  . $this->user->hash_activate . "  > Ative sua Conta");

        }

        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($mail);

            if ($response) {
                return response()->json(["success" => true, "message" => "Email enviado para " . $this->user->email]);
            } else {
                return response()->json(["success" => false, "message" => "Erro no envio do email"]);
            }
        } catch (Exception $e) {
            return response()->json(["success" => true, "message" => "Erro no envio do email " . $e->getMessage()]);
        }

    }

    public function reenvioMailActivate($options = [])
    {

        $mail = new Mail();
        if (!empty($options)) {

            if ($this->user == null) {
                $mail->addTo($options['to'], $options['name']);
            } else {
                $mail->addTo($this->user->email, $options['name']);
            }

            $mail->setFrom($options['fromEmail'], 'Pida Delivery');
            $mail->setSubject($options['subject']);
            $mail->addContent("text/html", "<a href=" . urldecode(getenv('APP_URL_FRONT')). "/login/ativar_conta/" . $options['hash'] . "  > Ative sua Conta");

        }

        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($mail);

            if ($response) {
                return 'true'; //response()->json(["success" => true, "message" => "Email enviado para ".$this->user->email]);
            } else {
                return 'false'; //response()->json(["success" => false, "message" => "Erro no envio do email"]);
            }
        } catch (Exception $e) {
            return 'false'; //response()->json(["success" => true, "message" => "Erro no envio do email ".$e->getMessage()]);
        }

    }

    private function generateCode()
    {

        $code = round(microtime(true) * 1000);
        $code = substr($code, -6);

        return $code;
    }
}
