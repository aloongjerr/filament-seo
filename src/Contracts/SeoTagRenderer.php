<?php

namespace AloongJerr\FilamentSeo\Contracts;

use Illuminate\Support\HtmlString;

interface SeoTagRenderer
{
    public function render(): HtmlString;
}
