<?php

namespace AloongJerr\FilamentSeo\Services;

use AloongJerr\FilamentSeo\Contracts\GroupSeoTag;
use AloongJerr\FilamentSeo\Contracts\RenderableSeoTag;
use AloongJerr\FilamentSeo\Contracts\SeoRenderer as SeoRendererContract;
use AloongJerr\FilamentSeo\Registry\SeoTagRegistry;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class SeoRenderer implements SeoRendererContract
{
    protected ?Model $model = null;

    public function __construct(
        protected SeoTagRegistry $registry,
        protected SeoValueResolver $valueResolver,
    ) {}

    public function render(): Htmlable
    {
        $html = collect($this->registry->all())
            ->when(
                $this->model,
                function (Collection $collection, Model $model) {
                    return $collection->map(
                        function (RenderableSeoTag $tag) use ($model) {
                            $this->resolveTagValue($tag, $model);

                            return $tag;
                        }
                    );
                }
            )
            ->filter(fn (RenderableSeoTag $tag) => $tag->isRenderable())
            ->map(fn (RenderableSeoTag $tag) => $tag->render()->toHtml())
            ->implode("\n");

        return new HtmlString($html);
    }

    public function model(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    protected function resolveTagValue(RenderableSeoTag $tag, Model $model): void
    {
        $value = $this->valueResolver->resolve(
            $model,
            $tag->key(),
        );

        if ($tag instanceof GroupSeoTag) {
            foreach ($value ?? [] as $key => $item) {
                $tag->set($key, $item);
            }

            return;
        }

        $tag->value($value);
    }
}
