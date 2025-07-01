<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class ContactRequest extends Model
{
    protected $table = 'contact_requests';
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'message',
        'service_id',
        'status',
        'source',
    ];
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
