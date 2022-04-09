<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Busine;
use App\Models\Busine_endereco;
use App\Models\Busine_config;
use App\Util\ClearValue;
use App\Util\ImageUpload;
use Illuminate\Http\Response;
use Log;

class BusineController extends Controller
{

    // public function index(){
    //     return view('pages.busine.create');
    // }

    public function store(Request $request)
    {
    
        // return response()->json(['mensagem' => $data], 200);
        
        $data = $request->all()['data'];
        $address = $request->all()['address'];
        $configs = $request->all()['configs'];
        
        $busine_config = array(
            'delivery_time' => $configs['deliveryTime'],
            'valor_atrr_excedido' => $configs['taxaAttr'],
            'valor_frete' => $configs['frete'],
        );


        $busine_address = array(
            'cidade' => $address['city'].' - '.$address['state'],
            'bairro' => $address['district'],
            'rua' => $address['street'],
            'cep' => $address['postalCode'],
            'numero' => $address['number'],
            'lat_empresa' => $address['lat'],
            'log_empresa' => $address['lng'],
        );

        $user = Auth::user();
        
        $busine_config = Busine_config::create($busine_config);
        if($busine_config):
            $busine_address = Busine_endereco::create($busine_address);
            if($busine_address):
                $busine = array(
                    'nome' => $data['companyName'],
                    'nome_fantasia' => $data['nameFantasy'],
                    'docs' => $data['docs'],
                    'telefone' => $data['phone'],
                    'seguimento' => $data['tracking'],
                    'busine_enderecos_id' => $busine_address->id,
                    'busine_configs_id' => $busine_config->id,
                    'admin_id' => $user->id
                );
        
                $busine = Busine::create($busine);

                // Log::debug($busine);

                if(!empty($busine)):
                    $this->file($data['logo']);
                    response()->json(['mensagem' => 'A empresa foi cadastrada com sucesso'], 200);
                endif;
                
            else:
                return response()->json(['mensagem' => 'Houve um erro ao tentar salvar o endereço da empresa'], 400);
            endif;

        else:
            return response()->json(['mensagem' => 'Houve um erro ao tentar salvar as configurações da empresa'], 400);
        endif;


    }

    public function updateBusineData(Request $request){
        $data = $request->all();
        $busine = Auth::user()->busine()->first();
        $telefone = null;
        Log::debug($request['phone']);

        if(isset($data['extra_data'])):
            $telefone = ClearValue::clearPhone($data['extra_data']);
        else:
            $telefone = ClearValue::clearPhone($request['phone']);
        endif;

        $busine->telefone = $telefone;
        $busine->save();
        $this->file($request);

    }

    public function updateBusineConfigs(Request $request){
        
        $configsUpdate = array(
            'delivery_time' => $request['b_delivery_time'],
            'valor_atrr_excedido' => str_replace(',', '.', $request['b_taxa_attr']),
            'valor_frete' => str_replace(',', '.', $request['b_frete']),
            'status_openCloser' => $request['b_status']
        );

        $busine = Auth::user()->busine()->first();
        $busine_config = Busine_config::find($busine->id);

        $busine_config->update($configsUpdate);

        if($busine_config){
            return response()->json(['status' => 200]);
        }else{
            return response()->json(['status' => 400]);
        }
    }

    public function file($image){

        $user = Auth::user();
        $busine = $user->busine()->first();
        $busineLogo = $busine->url_img_busine;
       
        $directory = getenv('EMPRESA_PATH_LOGO');
        $files = Storage::files($directory);
        $imageExists = false;
        $img = "";
        
        foreach($files as $file):
            $file = explode('/', $file)[2];
            Log::debug($file);

            if($busineLogo != null && $busineLogo == $file ){
                $imageExists = true;
                $img = $file;
            }
        endforeach;

        if($imageExists) {
            Storage::delete($directory.'/'.$img);
        }

        $imageSaved = ImageUpload::uploadImage($image, $directory);

        $busine->url_img_busine = $imageSaved['mensagem'];
        $busine->save();
    }

    function clearCPF_CNPJ($valor){
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("/", "", $valor);
        return $valor;
    }
    
}
