<?php

namespace AloongJerr\FilamentSeo\Contracts;

use Illuminate\Contracts\Support\Htmlable;

interface SeoRenderer
{
    public function render(): Htmlable;
}
