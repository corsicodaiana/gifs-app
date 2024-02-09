<?php

namespace App\Handlers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\InputBag;
use Illuminate\Http\Request;
use Domain\Repositories\LogRequestRepositoryInterface;
use Illuminate\Support\Facades\Auth;


class BuscarGifPorIdHandler
{

    private $logRequestRepositoryInterface;

    function __construct(
        LogRequestRepositoryInterface $logRequestRepositoryInterface
    )
    {
        $this->logRequestRepositoryInterface = $logRequestRepositoryInterface;
    }

    function handle($request)
    {
        $validator = Validator::make($request->all(), [
            "id" => 'required|string'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $id = $request->input('id');

        $url = "https://api.giphy.com/v1/gifs/{$id}?api_key=" . env('API_KEY');

        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 30,
        );

        $ch = curl_init();
        
        curl_setopt_array($ch, $defaults);
        
        $respuesta = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $respuesta = json_decode($respuesta);
        
        if($respuesta){
            $usuario = Auth::user()->name;
            $servicio = 'buscar gif por id';
            $this->logRequestRepositoryInterface->saveLogRequest($usuario,$servicio,$request,$http_code,$respuesta,'');

            return response()->json(['data' => $respuesta],200);
        }else{
            return response()->json(['error' => 'Not found'], 404);
        }
    }
}
