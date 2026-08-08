<?php

namespace AloongJerr\FilamentSeo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $seo_site_id
 * @property string|null $title_prefix
 * @property string|null $title_suffix
 * @property array $tags
 */
class SeoSetting extends Model
{
    protected $table = 'seo_settings';

    protected $fillable = [
        'seo_site_id',
        'title_prefix',
        'title_suffix',
        'tags',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(config('filament-seo.models.seo_site'), 'seo_site_id');
    }
}
