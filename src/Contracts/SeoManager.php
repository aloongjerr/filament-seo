<?php

namespace AloongJerr\FilamentSeo\Contracts;

interface SeoManager
{
    public function title(?string $title = null): ?string;
}
