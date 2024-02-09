<?php

namespace App\Handlers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\InputBag;
use Illuminate\Http\Request;
use Domain\Repositories\LogRequestRepositoryInterface;
use Illuminate\Support\Facades\Auth;


class BuscarGifsHandler
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
            "query" => 'bail|required|string',
            "limit" => 'bail|numeric',
            "offset" => 'bail|numeric'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $query = str_replace(" ", "+", $request->input('query'));
        $limit = $request->input('limit');
        $offset = $request->input('offset');

        $url = "http://api.giphy.com/v1/gifs/search?q={$query}&api_key=" . env('API_KEY') . "&limit={$limit}&offset={$offset}";
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
            $servicio = 'buscar gifs';
            $this->logRequestRepositoryInterface->saveLogRequest($usuario,$servicio,$request,$http_code,$respuesta,'');
            
            return response()->json(['data' => $respuesta],200);
        }else{
            return response()->json(['error' => 'ERROR: Not found'], 404);
        }
    }
}
