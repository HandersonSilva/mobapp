<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busine;
use App\Models\Unidade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Log;
use Exception;

class UnidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getUnidadeAll()
    {
       
        $user = Auth::user();
        $busine = $user->busine()->first();
        $unidadeList = [];

        if (!$busine){
            return response()->json(["mensagem"=>"Usuário não autenticado","data"=> null],403);
        }

        try{

            $unidadeList = Unidade::where('busine_id', $busine->id)
                                     ->orderBy('id', 'desc')->get();

            if(!$unidadeList){
                 return response()->json(["mensagem"=>"Error ao buscar os registro","data"=> null],400);
            }

            return response()->json(["mensagem"=>"","data"=> $unidadeList],200);

        }catch(Exception $e){
            Log::debug('Error ao acessar banco '.$e->getMessage());
            return response()->json(["mensagem"=>"Error ao buscar o registro","data"=> null],400);
        }
               
    }
}
