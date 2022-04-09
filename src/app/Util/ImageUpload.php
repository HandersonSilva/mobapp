<?php
namespace App\Util;

use Illuminate\Support\Facades\Storage;
use Log;

class ImageUpload
{
    public static function uploadImage($file, $path){
        //atualizando
        $extImg = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');
        $mensagem = 'Imagem cadastrada com sucesso';
        $imgBase64 = $file['imgBase64'];
        $resultado = [
            'status' => false,
            'mensagem' => "Nehum arquivo recebido"
        ];

        if (empty($imgBase64)) {
             return  $resultado;
        }

        $ext =  $file['extensao'];
        $type = $file['type'];

       if (!in_array($ext, $extImg)) {
            $resultado['mensagem'] = "O formato " . $type . " não é permitido.";
            return  $resultado;
        }

        $nomeAtual = md5(uniqid()) . '_' . time() . '.' . $ext;

        // $directory = $directory != null ? $path : getenv('EMPRESA_PATH_LOGO');

        if (!ImageUpload::saveImageBase64($imgBase64, $type, $path . $nomeAtual)) {
            $resultado['mensagem'] = "Erro ao salvar a imagem";
            return  $resultado;
        }

        $resultado['status'] = true;
        $resultado['mensagem'] = $nomeAtual;
        return  $resultado;
    }


    public static function saveImageBase64($image, $type, $path) {

        $imgBase64 = str_replace('data:'.$type.';base64,', '', $image);
        $imgBase64 = str_replace(' ', '+', $imgBase64);
        $data = base64_decode($imgBase64);

        $status = Storage::put( $path, $data);

        return $status;
    }

    public static function getImgBase64($directory, $image){

        $base64 = base64_encode(Storage::get($directory.$image['nome']));
        $image_data = 'data:'.Storage::mimeType($directory.$image['nome']). ';base64,' . $base64;
       
        return $image_data;
    }

}