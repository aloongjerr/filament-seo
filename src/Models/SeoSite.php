<?php

namespace AloongJerr\FilamentSeo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SeoSite extends Model
{
    protected $table = 'seo_sites';

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

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('is_default', true);
    }

    public function matchDomain(string $domain): bool
    {
        return $this->domain === $domain;
    }
}
