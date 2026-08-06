<?php

namespace AloongJerr\FilamentSeo\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSite extends Model
{
    protected $fillable = [
        'name',
        'domain',
        'is_default',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
