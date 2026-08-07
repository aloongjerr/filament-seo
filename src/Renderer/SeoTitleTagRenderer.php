<?php

namespace AloongJerr\FilamentSeo\Renderer;

use AloongJerr\FilamentSeo\Contracts\SeoTagRenderer;
use AloongJerr\FilamentSeo\Services\SeoTitleGenerator;
use AloongJerr\FilamentSeo\Traits\RenderSeoTag;

class SeoTitleTagRenderer implements SeoTagRenderer
{
    use RenderSeoTag;

    public function __construct(
        protected SeoTitleGenerator $generator,
    ) {}

    protected function value(): string
    {
        if ($this->value) {
            return $this->generator->generate($this->value);
        }

        return $this->generator->generate();
    }

    protected function tag(string $value): string
    {
        return "<title>{$value}</title>";
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
