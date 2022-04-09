<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Busine_config;
use App\Models\Busine;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Log;

class BusineConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = $request->all();
        //Log::debug($data);
        $latitude =$data['latitude'];//'-5.779225'
        $longitude = $data['longitude'];//'-35.293158';
        $distancia = $data['distancia'];

       // Log::debug('POSICAO_USER = '.$latitude.",".$longitude);

        //Log::debug("Realizando consulta das empresas");
        //Listar todas as empresas
        $busines = DB::table('busines')
            ->select(
                DB::raw('distinct(`busines`.`id`)'),
                'nome_fantasia',
                'telefone',
                'seguimento',
                'url_img_busine',
                'docs',
                'busine_configs.status_openCloser',
                'busine_configs.valor_frete',
                'busine_enderecos.lat_empresa',
                'busine_enderecos.log_empresa',
                //calculo dos pontos
                DB::raw('((6371 * acos(
                cos( radians(' . $latitude . ') )
               * cos( radians(`busine_enderecos`.`lat_empresa`) )
               * cos( radians( `busine_enderecos`.`log_empresa` ) - radians(' . $longitude . ') )
               + sin( radians(' . $latitude . ') )
               * sin( radians( `busine_enderecos`.`lat_empresa`) )
               )
              ) *1.45 )AS distancia')
            )
            ->join('busine_configs', 'busine_configs.id', '=', 'busines.busine_configs_id')
            ->join('busine_enderecos', 'busine_enderecos.id', '=', 'busines.busine_enderecos_id')
            ->join('categorias', 'categorias.busine_id', '=', 'busines.id')
            ->join('produtos', 'produtos.categoria_id', '=', 'categorias.id')
            ->havingRaw('distancia <'. $distancia) //verificar a distancia
            ->where('status_busine', '=', 1)
            ->orderByRaw('distancia ASC')
            ->get()->toArray();

        Log::debug($busines);
        $array_temp = array();
        //verificar retorno
        if (!empty($busines)) {

            Log::debug("Consulta das empresas realizadas com sucesso");
            return response()->json($busines);

        } else {
            //Alterando o retorno da route list
            $retorno = [];
            return response()->json($retorno);
            Log::debug("Erro ao realizar consulta");

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Busine_config  $busine_config
     * @return \Illuminate\Http\Response
     */
    public function show(Busine_config $busine_config)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Busine_config  $busine_config
     * @return \Illuminate\Http\Response
     */
    public function edit(Busine_config $busine_config)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Busine_config  $busine_config
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Busine_config $busine_config)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Busine_config  $busine_config
     * @return \Illuminate\Http\Response
     */
    public function destroy(Busine_config $busine_config)
    {
        //
    }

    /**
     * Config busine
     *
     * @return \Illuminate\Http\Response
     */
    public function getBusineConfig($idBusine)
    {
        //buscando os horarios
        try {

            $horario_funcionamento = DB::table('horario_busines')
                ->select('horario_busines.*')
                ->where('horario_busines.busines_id', '=', $idBusine)
                ->get()->toArray();

            //Acrescentar dados de configuração nesse select
            $busines_config = DB::table('busines')
            ->select('busine_configs.valor_atrr_excedido',
                     'busine_configs.fideliza_cliente',
                     'busine_enderecos.cidade')
            ->join('busine_configs', 'busine_configs.id','=', 'busines.busine_configs_id')
            ->join('busine_enderecos', 'busine_enderecos.id','=', 'busines.busine_enderecos_id')
            ->where('busines.id', $idBusine)
            ->get()->toArray();

            //implementar busca dos slides
            $slide_promotion = DB::table('slide_promotions')
            ->select('slide_promotions.slide_1',
                     'slide_promotions.slide_2',
                     'slide_promotions.slide_3',
                     'slide_promotions.slide_4')
           //->where('loan_officers', 'like', '%' . $officerId)
           ->where('slide_promotions.cidade', $busines_config[0]->cidade)
           ->get()->toArray();

           Log::debug("Buscando promoções para a cidade ".$busines_config[0]->cidade);
           Log::debug($slide_promotion);


           if(!$slide_promotion){
            $slide_promotion = array(
                'slide_1' => "pida1.jpeg",
                'slide_2' => "pida2.jpg",
                'slide_3' => "pida3.jpeg",
                'slide_4' => "pida4.jpeg",
            );
           }

            if ($horario_funcionamento) {
                Log::debug("Retornando os horarios ");
                $retorno = [
                    'horario' => $horario_funcionamento,
                    'valor_atrr_excedido'=> $busines_config[0]->valor_atrr_excedido,
                    'fideliza_cliente'=> $busines_config[0]->fideliza_cliente,
                    'slide_promotion'=>$slide_promotion[0]
                ];
                return response()->json([$retorno]);

            } else {

                Log::debug("Erro ao retornar os horarios ");
                return response()->json(['horario' => null]);
            }

            Log::debug("Get Horarios OK");
            return response()->json(['horario' => null]);
        } catch (Exception $e) {
            Log::debug("Get Horarios Fail".$e->getMessage());
            return response()->json(['horario' => null]);
        }

    }

    public function getBusineData($id){

       $busine = Busine::find($id);
       $retorno = null;
       $data_busine = DB::table('busines')
       ->select('busine_enderecos.*', 'busine_configs.*', 'horario_busines.*')
       ->join('busine_enderecos', 'busine_enderecos.id','=', 'busines.busine_enderecos_id')
       ->join('busine_configs','busine_configs.id', '=', 'busines.busine_configs_id')
       ->join('horario_busines', 'horario_busines.busines_id', '=','busines.id')
       ->where('busines.id', $busine->id)
       ->get();

       if($data_busine):
            $retorno = array(
                'busine' => $busine,
                'data_busine' => $data_busine
            );
        else:

            $retorno = [];

        endif;

       return response()->json($retorno);
    }

}
