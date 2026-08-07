<?php

namespace AloongJerr\FilamentSeo\Contracts;

use Illuminate\Support\HtmlString;

interface SeoManager
{
    public function title(string $title): self;

    public function render(): HtmlString;
}
