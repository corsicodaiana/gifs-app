<?php

namespace Domain\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogRequest extends Model
{
    use HasFactory;

    protected $table = 'log_requests';

    protected $fillable = [
        'usuario',
        'servicio',
        'request',
        'http_code',
        'response',
        'ip_origen',
    ];

	public $timestamps = true;
}
