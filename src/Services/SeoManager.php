<?php

namespace AloongJerr\FilamentSeo\Services;

use AloongJerr\FilamentSeo\Contracts\SeoManager as SeoManagerContract;
use AloongJerr\FilamentSeo\Renderer\SeoTitleTagRenderer;
use Illuminate\Support\HtmlString;

class SeoManager implements SeoManagerContract
{
    public function __construct(
        protected SeoTitleTagRenderer $titleRenderer,
    ) {}

    public function title(string $title): self
    {

        $this->titleRenderer->setValue($title);

        return $this;
    }

    public function render(): HtmlString
    {
        return $this->titleRenderer->render();
    }
}
