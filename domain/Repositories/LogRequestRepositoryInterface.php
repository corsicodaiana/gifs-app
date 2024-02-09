<?php

namespace Domain\Repositories;

interface LogRequestRepositoryInterface
{
    function saveLogRequest(string $usuario, string $servicio, string $request, int $http_code, string $response, string $ip_origen);
    function getListLog();
}