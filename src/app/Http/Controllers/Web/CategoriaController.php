<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Busine;
use App\Models\CategoriaAtributo;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Log;
use Exception;
class CategoriaController extends Controller
{

 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categoriaAttrIndex(Request $request)
    {
        $data = $request->all();

        if (!in_array($data['ordenacao'], ['id','nome_categ_atrib','permite_duplic'])) { 
            return response()->json(["mensagem"=>"Error na ordenação do grid","data"=> ""],400);
        }
        //
        $user = Auth::user();
        $busine = $user->busine()->first();

        if (!$busine){
            return response()->json(["mensagem"=>"Usuário não autenticado","data"=> null],403);
        }

        try{
            $categoriasAtributoTotal = CategoriaAtributo::where('nome_categ_atrib', 'like','%'.$data['textBusca'].'%')
                                        ->where('busine_id', $busine->id)
                                        ->count();

            $categoriasAtributo = CategoriaAtributo::where('nome_categ_atrib', 'like','%'.$data['textBusca'].'%')
                            ->where('busine_id', $busine->id)
                            ->offset($data['quantidade'])
                            ->limit($data['pagina'])
                            ->orderBy($data['ordenacao'], $data['short'])
                            ->get()->toArray();

        }catch(Exception $e){
            Log::debug('Error ao acessar banco '.$e->getMessage());
            return response()->json(["mensagem"=>"Error ao buscar dados","data"=> ""],400);
        }
       
        return response()->json(["total"=>$categoriasAtributoTotal,"data"=> $categoriasAtributo],200);
      
    }

    public function categoriaProdutoIndex(Request $request)
    {
        $data = $request->all();

        if (!in_array($data['ordenacao'], ['id','nome_categ'])) { 
            return response()->json(["mensagem"=>"Error na ordenação do grid","data"=> ""],400);
        }

        $user = Auth::user();
        $busine = $user->busine()->first();

        if (!$busine){
            return response()->json(["mensagem"=>"Usuário não autenticado","data"=> null],403);
        }

        try{
            $categoriasTotal = Categoria::where('nome_categ', 'like','%'.$data['textBusca'].'%')
                            ->where('busine_id', $busine->id)
                            ->count();

            $categorias = Categoria::where('nome_categ', 'like','%'.$data['textBusca'].'%')
                            ->where('busine_id', $busine->id)
                            ->offset($data['quantidade'])
                            ->limit($data['pagina'])
                            ->orderBy($data['ordenacao'], $data['short'])
                            ->get()->toArray();
        }catch(Exception $e){
            Log::debug('Error ao acessar banco '.$e->getMessage());
            return response()->json(["mensagem"=>"Error ao buscar dados","data"=> ""],400);
        }

        return response()->json(["total"=>$categoriasTotal,"data"=> $categorias],200);
       
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $categoriaAtributo = "";

         $validador = $this->validarCampos($data);

        if ($validador['STATUS']) {
            return response()->json(["mensagem"=>$validador['MSG'],"data"=> ""],400);
        }

        $user = Auth::user();
        $busine = $user->busine()->first();

        if (!$busine){
            return response()->json(["mensagem"=>"Usuário não autenticado","data"=> null],403);
        }

        try{

            if (!empty($data['id'])){
                $categoriaAtributo = CategoriaAtributo::find($data['id']);
            }else{
                $categoriaAtributo = new CategoriaAtributo;
            }

            $categoriaAtributo->nome_categ_atrib = $data['nome_categ_atrib'];
            $categoriaAtributo->permite_duplic = $data['permite_duplic'];
            $categoriaAtributo->busine_id = $busine->id;

            if($categoriaAtributo->save()){
                return response()->json(["mensagem"=>"Registro gravado com sucesso","data"=> null],200);
            }
               
        }catch(Exception $e){
            Log::debug('Error ao acessar banco '.$e->getMessage());
            return response()->json(["mensagem"=>"Error ao gravar o registro","data"=> null],400);
        }

    }

    public function storeCategoria(Request $request)
    {
        $data = $request->all();
        $categoriaProduto = "";

        $validador = $this->validarCamposCategoria($data);

        if ($validador['STATUS']) {
            return response()->json(["mensagem"=>$validador['MSG'],"data"=> ""],400);
        }

        $user = Auth::user();
        $busine = $user->busine()->first();

        try{

            if (!empty($data['id'])){
                $categoriaProduto = Categoria::find($data['id']);
            }else{
                $categoriaProduto = new Categoria;
            }

            $categoriaProduto->nome_categ = $data['nome_categ'];
            $categoriaProduto->busine_id = $busine->id;

            if($categoriaProduto->save()){
                return response()->json(["mensagem"=>"Registro gravado com sucesso","data"=> null],200);
            }
                  
        }catch(Exception $e){
            Log::debug('Error ao acessar banco '.$e->getMessage());
            return response()->json(["mensagem"=>"Error ao gravar o registro","data"=> null],400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoriaAtributo = CategoriaAtributo::find($id);

        if($categoriaAtributo === null){
            return response()->json(["mensagem"=>"Error ao excluir o registro","data"=> null],400);
        }

        try{

            if($categoriaAtributo->delete()){

                return response()->json(["mensagem"=>"Registro excluído com sucesso","data"=> null],200);
            };

        }catch(Exception $e){
            Log::debug('Error ao acessar banco '.$e->getMessage());
            return response()->json(["mensagem"=>"Error ao excluir o registro","data"=> null],400);
        }

    }

    public function destroyCategoria($id)
    {
       
        $categoriaProduto = Categoria::find($id);

        if($categoriaProduto === null){
            return response()->json(["mensagem"=>"Error ao excluir o registro","data"=> null],400);
        }

        try
        {

            if($categoriaProduto->delete()){

                return response()->json(["mensagem"=>"Registro excluído com sucesso","data"=> null],200);

            };

        }catch(Exception $e){
            Log::debug('Error ao acessar banco '.$e->getMessage());
            return response()->json(["mensagem"=>"Error ao excluir o registro","data"=> null],400);
        }
    }

    
    public function getCategoriaAll()
    {
       
        $user = Auth::user();
        $busine = $user->busine()->first();
        $categorias = [];

        if (!$busine){
            return response()->json(["mensagem"=>"Usuário não autenticado","data"=> null],403);
        }

        try{

            $categorias = Categoria::where('busine_id', $busine->id)
                                     ->orderBy('id', 'desc')->get();

            if(!$categorias){
                 return response()->json(["mensagem"=>"Error ao buscar os registro","data"=> null],400);
            }

            return response()->json(["mensagem"=>"","data"=> $categorias],200);

        }catch(Exception $e){
            Log::debug('Error ao acessar banco '.$e->getMessage());
            return response()->json(["mensagem"=>"Error ao buscar o registro","data"=> null],400);
        }
               
    }

    public function getCategoriaAtributoAll()
    {
       
        $user = Auth::user();
        $busine = $user->busine()->first();
        $categoriaAtributo = [];

        if (!$busine){
            return response()->json(["mensagem"=>"Usuário não autenticado","data"=> null],403);
        }

        try{

            $categoriaAtributo = CategoriaAtributo::where('busine_id', $busine->id)
                                     ->orderBy('id', 'desc')->get();

            if(!$categoriaAtributo){
                 return response()->json(["mensagem"=>"Error ao buscar os registro","data"=> null],400);
            }

            return response()->json(["mensagem"=>"","data"=> $categoriaAtributo],200);

        }catch(Exception $e){
            Log::debug('Error ao acessar banco '.$e->getMessage());
            return response()->json(["mensagem"=>"Error ao buscar o registro","data"=> null],400);
        }
               
    }


    public function validarCampos($data)
    {

        $retorno = [
            "STATUS" => "",
            'htmlError' => "",
            "MSG" => "Tudo ok",
        ];


        if ($data) {
            $validator = \Validator::make($data, [
                'nome_categ_atrib' => 'required|max:120|min:3',

            ], [
                "required" => "O campo categoria não pode estar em branco",
                "nome_categ_atrib.min" => "O campo categoria não pode conter menos de 3 caracteres",
                "nome_categ_atrib.max" => "O campo categoria não pode conter mais que 120 caracteres",

            ]
            );
            if ($validator->fails()) {
                $retorno = [
                    "STATUS" => $validator->fails(),
                    'htmlError' => $validator->errors()->all(),
                    "MSG" => "Falha ao validar os dados",
                ];
                return $retorno;
            }
            return $retorno;
        } 

    }

    public function validarCamposCategoria($data)
    {

        $retorno = [
            "STATUS" => "",
            'htmlError' => "",
            "MSG" => "Tudo ok",
        ];

        if ($data) {
            $validator = \Validator::make($data, [
                'nome_categ' => 'required|max:120|min:3',

            ], [
                "required" => "O campo categoria não pode estar em branco",
                "nome_categ.min" => "O campo categoria não pode conter menos de 3 caracteres",
                "nome_categ.max" => "O campo categoria não pode conter mais que 120 caracteres",

            ]
            );
            if ($validator->fails()) {
                $retorno = [
                    "STATUS" => $validator->fails(),
                    'htmlError' => $validator->errors()->all(),
                    "MSG" => "Falha ao validar os dados",
                ];
                return $retorno;
            }
            return $retorno;
        } 

    }

   
}
