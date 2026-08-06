<?php

namespace AloongJerr\FilamentSeo\Services;

use AloongJerr\FilamentSeo\Contracts\SeoManager as SeoManagerContract;

class SeoManager implements SeoManagerContract
{
    public function title(?string $title = null): ?string
    {
        return $title;
    }
}
