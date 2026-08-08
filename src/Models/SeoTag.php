<?php

namespace AloongJerr\FilamentSeo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $modelable_type
 * @property int $modelable_id
 * @property array|null $tags
 */
class SeoTag extends Model
{
    protected $table = 'seo_tags';

    protected $fillable = [
        'modelable_type',
        'modelable_id',
        'tags',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }

    public function modelable(): MorphTo
    {
        return $this->morphTo();
    }
}
