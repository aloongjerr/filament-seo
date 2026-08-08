<?php

namespace AloongJerr\FilamentSeo\Contracts;

use AloongJerr\FilamentSeo\Models\SeoTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property SeoTag|Model $seoTags
 */
interface HasSeo
{
    public function getDefaultSeoTitle(): ?string;

    public function getDefaultSeoValue(string $key): mixed;

    public function seoTags(): MorphOne;
}
