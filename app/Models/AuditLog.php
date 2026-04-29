<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'trace_id',
        'source',
        'event_type',
        'order_id',
        'syspro_order_no',
        'customer_number',
        'http_status',
        'success',
        'error_message',
        'request_payload',
        'response_payload',
        'meta',
    ];

    protected $casts = [
        'success' => 'bool',
        'http_status' => 'int',
        'request_payload' => 'array',
        'response_payload' => 'array',
        'meta' => 'array',
    ];
}

