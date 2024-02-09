<?php

namespace Presentation\Http\Actions;

use App\Handlers\BuscarGifPorIdHandler;
use Illuminate\Http\Request;

class BuscarGifPorIdAction
{
    private $handler;

    public function __construct(BuscarGifPorIdHandler $buscarGifPorIdHandler)
    {
        $this->handler = $buscarGifPorIdHandler;
    }

    public function execute(Request $request)
    {
        return $this->handler->handle($request);
    }
}
