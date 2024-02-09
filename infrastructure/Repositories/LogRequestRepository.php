<?php

namespace Infrastructure\Repositories;

use Domain\Repositories\LogRequestRepositoryInterface;
use Domain\Entities\LogRequest;

class LogRequestRepository implements LogRequestRepositoryInterface
{
    function saveLogRequest(string $usuario, string $servicio, string $request, int $http_code, string $response, string $ip_origen)
    {
        $logRequest = new LogRequest();
        $logRequest->usuario = $usuario;
        $logRequest->servicio = $servicio;
        $logRequest->request = $request;
        $logRequest->http_code = $http_code;
        $logRequest->response = $response;
        $logRequest->ip_origen = $ip_origen;
        $respuesta = $logRequest->save();
        return $respuesta;
    }

    function getListLog()
    {
        $logRequests = LogRequest::all();
        return $logRequests;
    }
}