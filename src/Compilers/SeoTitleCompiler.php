<?php

namespace AloongJerr\FilamentSeo\Compilers;

use AloongJerr\FilamentSeo\Contracts\SeoCompiler;
use AloongJerr\FilamentSeo\Tags\AbstractSeoTag;

class SeoTitleCompiler implements SeoCompiler
{
    public function compile(AbstractSeoTag $tag): string
    {
        return $tag->value();
    }

}
