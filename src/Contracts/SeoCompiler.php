<?php

namespace AloongJerr\FilamentSeo\Contracts;

use AloongJerr\FilamentSeo\Tags\AbstractSeoTag;

interface SeoCompiler
{
    public function compile(AbstractSeoTag $tag): string;
}
