<?php

namespace Presentation\Http\Actions;

use App\Handlers\BuscarGifsHandler;
use Illuminate\Http\Request;

class BuscarGifsAction
{
    private $handler;

    public function __construct(BuscarGifsHandler $buscarGifsHandler)
    {
        $this->handler = $buscarGifsHandler;
    }

    public function execute(Request $request)
    {
        return $this->handler->handle($request);
    }
}
