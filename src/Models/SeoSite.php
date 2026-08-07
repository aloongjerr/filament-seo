<?php

namespace AloongJerr\FilamentSeo\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $name
 * @property string $domain
 * @property bool $is_default
 * @property bool $is_active
 * @property SeoSetting|null $setting
 * @method static active()
 * @method static default()
 */
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

    public function setting(): HasOne
    {
        return $this->hasOne(config('filament-seo.models.seo_setting'), 'seo_site_id');
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    #[Scope]
    protected function defaultSite(Builder $query): Builder
    {
        return $query->where('is_default', true);
    }

    public function matchesDomain(string $domain): bool
    {
        return $this->domain === $domain;
    }
}
