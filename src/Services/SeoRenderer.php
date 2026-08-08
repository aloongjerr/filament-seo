<?php

namespace AloongJerr\FilamentSeo\Services;

use AloongJerr\FilamentSeo\Contracts\RenderableSeoTag;
use AloongJerr\FilamentSeo\Contracts\SeoRenderer as SeoRendererContract;
use AloongJerr\FilamentSeo\Registry\SeoTagRegistry;
use AloongJerr\FilamentSeo\Tags\AbstractSeoTag;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class SeoRenderer implements SeoRendererContract
{
    public function __construct(
        protected SeoTagRegistry $registry
    ) {}

    public function render(): Htmlable
    {
        $html = collect($this->registry->all())
            ->filter(fn (RenderableSeoTag $tag) => $tag->isRenderable())
            ->map(fn (RenderableSeoTag $tag) => $tag->render()->toHtml())
            ->implode("\n");

        return new HtmlString($html);
    }
}
