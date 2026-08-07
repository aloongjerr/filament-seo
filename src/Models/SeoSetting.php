<?php

namespace AloongJerr\FilamentSeo\Models;

use AloongJerr\FilamentSeo\Enums\RobotsDirective;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $seo_site_id
 * @property string|null $title_prefix
 * @property string|null $title_suffix
 * @property string|null $default_title
 * @property string|null $default_description
 * @property RobotsDirective $robots
 */
class SeoSetting extends Model
{
    protected $table = 'seo_settings';

    protected $fillable = [
        'seo_site_id',
        'title_prefix',
        'title_suffix',
        'default_title',
        'default_description',
        'robots',
    ];

    protected function casts(): array
    {
        return [
            'robots' => RobotsDirective::class,
        ];
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(config('filament-seo.models.seo_site'), 'seo_site_id');
    }
}
