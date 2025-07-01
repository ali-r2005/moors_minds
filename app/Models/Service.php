<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Project;
use App\Models\ContactRequest;

class Service extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'use_cases',
        'features',
        'image_url',
        'cta_label',
        'cta_link',
        'category_id',
    ];
    protected $casts = [
        'use_cases' => 'array',
        'features' => 'array',
        'image_url' => 'string',
        'category_id' => 'integer',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function contactRequests()
    {
        return $this->hasMany(ContactRequest::class);
    }
}
