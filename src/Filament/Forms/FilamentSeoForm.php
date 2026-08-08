<?php

namespace AloongJerr\FilamentSeo\Filament\Forms;

use AloongJerr\FilamentSeo\Contracts\HasSeoFormSchema;
use AloongJerr\FilamentSeo\Registry\SeoTagRegistry;

class FilamentSeoForm
{
    protected ?array $tagKeys = null;

    public function __construct(
        protected SeoTagRegistry $registry,
    ) {}

    public static function make(): static
    {
        return app(static::class);
    }

    public function tags(array $tags): static
    {
        $this->tagKeys = $tags;

        return $this;
    }

    public function schema(): array
    {
        $tags = $this->tagKeys === null
            ? $this->registry->all()
            : $this->registry->only($this->tagKeys);

        return collect($tags)
            ->filter(
                fn ($tag) => $tag instanceof HasSeoFormSchema
            )
            ->map(
                fn (HasSeoFormSchema $tag) => $tag->getFormSchema()
            )
            ->filter(
                fn (array $schema) => filled($schema)
            )
            ->flatMap(
                fn (array $schema) => $schema
            )
            ->values()
            ->all();
    }
}
