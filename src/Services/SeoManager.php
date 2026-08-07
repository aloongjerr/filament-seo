<?php

namespace AloongJerr\FilamentSeo\Services;

use AloongJerr\FilamentSeo\Contracts\SeoManager as SeoManagerContract;

class SeoManager implements SeoManagerContract
{
    public function __construct(
        protected SeoTitleGenerator $titleGenerator,
    ) {}

    public function title(?string $title = null): ?string
    {
        return $this->titleGenerator->generate($title);
    }
}
