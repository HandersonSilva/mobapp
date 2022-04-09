<?php

namespace App\Mail;

use Log;
use SendGrid\Mail\Mail;

class SendMail
{


    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct()
    {
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

        $mail = new Mail();
        if (!empty($options)) {
            $mail->addTo($options['to'], $options['name']);
            $mail->setFrom($options['fromEmail'], getenv('APP_NAME'));
            $mail->setSubject($options['subject']);
            $mail->addContent(
                "text/html",
                $options['content']
            );
        }

        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($mail);
            \Log::info(\json_encode($response));
            if ($response) {
                return 'true'; //response()->json(["success" => true, "message" => "Email enviado para ".$this->user->email]);
            } else {
                return 'false'; //response()->json(["success" => false, "message" => "Erro no envio do email"]);
            }
        } catch (Exception $e) {
            \Log::info($e->getMessage());
            return 'false'; //response()->json(["success" => true, "message" => "Erro no envio do email ".$e->getMessage()]);
        }
    }
}
