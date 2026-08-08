<?php

namespace AloongJerr\FilamentSeo\Services;

use AloongJerr\FilamentSeo\Contracts\RenderableSeoTag;
use AloongJerr\FilamentSeo\Contracts\SeoManager as SeoManagerContract;
use AloongJerr\FilamentSeo\Contracts\SeoRenderer as SeoRendererContract;
use AloongJerr\FilamentSeo\Registry\SeoTagRegistry;
use AloongJerr\FilamentSeo\Tags\SeoCanonicalTag;
use AloongJerr\FilamentSeo\Tags\SeoDescriptionTag;
use AloongJerr\FilamentSeo\Tags\SeoJsonLdTag;
use AloongJerr\FilamentSeo\Tags\SeoOpenGraphTag;
use AloongJerr\FilamentSeo\Tags\SeoRobotsTag;
use AloongJerr\FilamentSeo\Tags\SeoTitleTag;
use AloongJerr\FilamentSeo\Tags\SeoTwitterCardTag;
use BackedEnum;
use BadMethodCallException;
use Illuminate\Contracts\Support\Htmlable;

/**
 * @method SeoTitleTag title()
 * @method SeoDescriptionTag description()
 * @method SeoRobotsTag robots()
 * @method SeoCanonicalTag canonical()
 * @method SeoOpenGraphTag openGraph()
 * @method SeoTwitterCardTag twitterCard()
 * @method SeoJsonLdTag jsonLd()
 */
class SeoManager implements SeoManagerContract
{
    public function __construct(
        protected SeoTagRegistry $registry,
        protected SeoRendererContract $renderer,
    ) {}

    public function tag(BackedEnum | string $type): ?RenderableSeoTag
    {
        return $this->registry->get($type);
    }

    public function render(): Htmlable
    {
        return $this->renderer->render();
    }

    public function __call(string $method, array $arguments): RenderableSeoTag
    {
        $tag = $this->registry->getByMethod($method);

        if (! $tag) {
            throw new BadMethodCallException(
                "SEO tag method [{$method}] is not registered."
            );
        }

        return $tag;
    }
}
