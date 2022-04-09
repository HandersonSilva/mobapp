<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Busine;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Models\Produto;
use App\Models\Atributo;
use App\Util\ImageUpload;
use App\Models\ImageProduto;
use Illuminate\Support\Facades\Storage;
use Validator;
use Log;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $colunas =  ['id','nome_prod','permite_duplic','status_promo',
        'disponibilidade','valor_prod','estoque',
        'possui_attr','nome_categ','qtd_complementos'];

        if (!in_array($data['short'],$colunas)) { 
            return response()->json(["mensagem"=>"Error na ordenação do grid","data"=> ""],400);
        }
        
        $user = Auth::user();
        $busine = $user->busine()->first();

        if (!$busine){
            return response()->json(["mensagem"=>"Usuário não autenticado","data"=> null],403);
        }

        try{
            $produtosTotal = Produto::where('nome_prod', 'like','%'.$data['textBusca'].'%')
                                        ->where('busine_id', $busine->id)
                                        ->count();

            $produtos = DB::table('produtos')
                            ->select(
                                'produtos.*',
                                'categorias.nome_categ',
                            )
                            ->join('categorias', 'categorias.id', '=', 'produtos.categoria_id')
                            ->where('nome_prod', 'like','%'.$data['textBusca'].'%')
                            ->where([
                                'produtos.busine_id' => $busine->id
                            ])
                            ->offset($data['quantidade'])
                            ->limit($data['pagina'])
                            ->orderBy($data['short'] , $data['ordenacao'] )
                            ->get()->toArray();

        }catch(Exception $e){
            Log::debug('Error ao acessar banco '.$e->getMessage());
            return response()->json(["mensagem"=>"Error ao buscar dados","data"=> ""],400);
        }
       
        return response()->json(["total"=>$produtosTotal,"data"=> $produtos],200);

    }

    public function getProduto($id)
    {
        $user = Auth::user();
        $busine = $user->busine()->first();

        if (!$id){
            return response()->json(["mensagem"=>"Dados inválidos","data"=> null],403);
        }

        $atributos = [];
        $imagens = [];
        $promocoes = [];

        try{
            
            $produto = Produto::find($id);

            if (!$produto){
                return response()->json(["mensagem"=>"Registro não encontrado","data"=> null],400);
            }

            if ($produto->possui_attr == 1){
                $atributos =  Atributo::where('produto_id', $produto->id)
                                        ->orderBy('id', 'desc')->get();
            }

            if (\intval($produto->status_promo) == 1){
                $promocoes = DB::table('promocoes')
                                ->select(
                                    'promocoes.id',
                                    'title_promocao',
                                )
                                ->join('promocao_produto', 'promocao_produto.promocao_id', '=', 'promocoes.id')
                                ->join('produtos', 'produtos.id', '=', 'promocao_produto.produto_id')
                                ->where([
                                    'produtos.id' => $produto->id
                                ])->get();
            }

            $resultImage =  ImageProduto::where('produto_id', $produto->id)
                                        ->orderBy('id', 'desc')->get();

             foreach($resultImage as $image){
                $directory = getenv('EMPRESA_PATH').$busine->docs."/produtos/";
                $imageBase64 = ImageUpload::getImgBase64($directory,$image);

                $image['img_base64'] = $imageBase64;

                array_push($imagens,$image);
              
             }


            $produto['atributo'] = $atributos;
            $produto['imagens'] = $imagens;
            $produto['promocoes'] = $promocoes;


        }catch(Exception $e){
            Log::debug('Error ao acessar banco '.$e->getMessage());
            return response()->json(["mensagem"=>"Error ao buscar dados","data"=> ""],400);
        }
       
        return response()->json(["mensagem"=>"","data"=> $produto],200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $validador = $this->validarCamposProdutos($data);

        if ($validador['STATUS']) {
            return response()->json(["mensagem"=>$validador['MSG'],"data"=> ""],400);
        }

        $user = Auth::user();
        $busine = $user->busine()->first();

        try{

            if (!empty($data['id'])){
                $produto = Produto::find($data['id']);
            }else{
                $produto = new Produto;
            }

            $produto->nome_prod = $data['nome_prod'];
            $produto->desc_prod = $data['desc_prod'];
            $produto->img_prod_url = $data['img_prod_url'];
            $produto->status_promo = $data['status_promo'];
            $produto->valor_prod = $data['valor_prod'];
            $produto->valor_custo = $data['valor_custo'];
            $produto->possui_attr = $data['possui_attr'];
            $produto->disponibilidade = $data['disponibilidade'];
            $produto->estoque = $data['estoque'];
            $produto->qtd_complementos = $data['qtd_complementos'];
            $produto->unidade_id = $data['unidade_id'];
            $produto->categoria_id = $data['categoria_id'];
            $produto->busine_id = $busine->id;

            if(!$produto->save()){
                return response()->json(["mensagem"=>"Error ao gravar o registro","data"=> null],400);
            }
            
            if (count($data['imagens']) == 0){
                $produto->delete();
                return response()->json(["mensagem"=>"Nenhuma imagem enviada para este produto","data"=> null],400);
            }

            $imageOldList = ImageProduto::where('produto_id', $produto->id)->get()->toArray();
            
            foreach($data['imagens'] as $imagem){
                $this->file($imagem,$produto->id);
            }

            if ($imageOldList){
               $this->deleteImage($imageOldList);
            }

            //salvando os atributos
            if ($produto->possui_attr > 0 && \sizeof($data['atributos'])){
                
                $deletedRows = Atributo::where('produto_id', $produto->id)->delete();

                foreach($data['atributos'] as $atributo){
                    unset($atributo['categoria_atributo_nome']);
                    $atributo['produto_id'] = $produto->id;
                    $atributoDB = Atributo::create($atributo);
                }
            }

            return response()->json(["mensagem"=>"Registro gravado com sucesso","data"=> null],200);
               
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
        $produto = Produto::find($id);

        if($produto === null){
            return response()->json(["mensagem"=>"Error ao excluir o registro","data"=> null],400);
        }

        try
        {
            $deletedRowsAtributos = Atributo::where('produto_id', $id)->delete();

            $imageOldList = ImageProduto::where('produto_id', $id)->get()->toArray();
            $deletedRowsImage = ImageProduto::where('produto_id', $id)->delete();
            
            if ($imageOldList){
               $this->deleteImage($imageOldList);
            }

            if($produto->delete()){

                return response()->json(["mensagem"=>"Registro excluído com sucesso","data"=> null],200);

            };

        }catch(Exception $e){
            Log::debug('Error ao acessar banco '.$e->getMessage());
            return response()->json(["mensagem"=>"Error ao excluir o registro","data"=> null],400);
        }
    }

    public function validarCamposProdutos($data)
    {
        $retorno = [
            "STATUS" => "",
            "MSG" => "",
        ];

        if ($data) {
            $validator = \Validator::make($data, [
                'nome_prod' => 'required|max:60|min:3',
                'desc_prod' => 'required|max:60|min:3',
                'valor_prod' => 'required|numeric',
                'valor_custo' => 'required|numeric',
                'estoque' => 'required|numeric',
                'categoria_id' => 'required|numeric|gt:0',
                'unidade_id' => 'required|numeric|gt:0',
                'possui_attr' => 'required|numeric',
                'disponibilidade' => 'required|numeric',
                'qtd_complementos' => 'required|numeric',
                'imagens'=> 'required'
            ],[
                "required" => "O campo é obrigatório",
                "min" => "O campo não pode conter menos de 3 caracteres",
                "max" => "O campo não pode conter mais que 60 caracteres",
                "numeric" => "O campo não pode conter letras",
            ]);

            if ($validator->fails()) {
                $retorno = [
                    "STATUS" => $validator->fails(),
                    "MSG" => "Falha ao validar os dados",
                ];

                return $retorno;
            }
            return $retorno;
        } 
    }

    public function file($image,$idProduto){

        $user = Auth::user();
        $busine = $user->busine()->first();
       
        $directory = getenv('EMPRESA_PATH').$busine->docs."/produtos/";

        $imageSaved = ImageUpload::uploadImage($image, $directory);

        try
        {
           if($image['imagemPadrao']){
                $produto = Produto::find($idProduto);
                $produto->img_prod_url =  $imageSaved['mensagem'];
                $produto->save();
            }
            
            if (!$imageSaved['status']){
                return false;
            }

            $imagem = new ImageProduto();
            $imagem->nome = $imageSaved['mensagem'];
            $imagem->imagem_padrao = $image['imagemPadrao'] ? 1 : 0;
            $imagem->produto_id = $idProduto;
            $imagem->save();

            return true;

        }catch(Exception $e){
            Log::debug('Error ao acessar o banco '.$e->getMessage());
            return false;
        }
    }

    public function deleteImage($listImage){
        $user = Auth::user();
        $busine = $user->busine()->first();
       
        $directory = getenv('EMPRESA_PATH').$busine->docs."/produtos";

        foreach($listImage as $img){
            if(Storage::exists($directory.'/'.$img['nome'])) {
                Storage::delete($directory.'/'.$img['nome']);
            }
        }
    }
}
