<?php
namespace App\Util;

class GetApi
{

    //get endereco usuraio via posição
    public function getEnderecoUser($lat, $long)
    {
        $keyApi = env('GEOCODE_API_KEY');
        // https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=YOUR_API_KEY
        $urlGeocodeEnd = "https://maps.googleapis.com/maps/api/geocode/json?address=R.+Ipangua%C3%A7u+59-NovaParnamirim+Parnamirim-RN+59152-370+Brasil&key=AIzaSyDjNpXyfZmkB01LqSXJg8iUbxikLaGZGyI";

        $urlGeocode = "https://maps.googleapis.com/maps/api/geocode/json?";
        $param = "latlng=" . $lat . "," . $long . "&key=" . $keyApi;
        //criando o recurso cURL
        $cr = curl_init();

        //definindo a url de busca
        curl_setopt($cr, CURLOPT_URL, "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $long . "&key=" . "AIzaSyCkdJUejasi3ti22Yt5aOMVIqFlLy-SF2c");

        //definindo a url de busca
        curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);

        //definino que o método de envio, será POST
        //curl_setopt($cr, CURLOPT_POST, true);

        //definindo os dados que serão enviados
        // curl_setopt($cr, CURLOPT_POSTFIELDS, "");

        //definindo uma variável para receber o conteúdo da página...
        $retorno = curl_exec($cr);

        //fechando-o para liberação do sistema.
        curl_close($cr); //fechamos o recurso e liberamos o sistema...

        //mostrando o conteúdo...
        return \json_decode($retorno);
    }
}
