<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'video_url',
        'images',
        'results',
        'service_id',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
