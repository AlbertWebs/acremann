<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLookup extends Model
{
    protected $fillable = [
        'reference_number', 'lookup_type', 'client_name', 'client_phone',
        'client_email', 'status_message', 'statement_path',
    ];
}
