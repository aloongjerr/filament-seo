<?php

namespace AloongJerr\FilamentSeo\Registry;

use AloongJerr\FilamentSeo\Contracts\RenderableSeoTag;
use AloongJerr\FilamentSeo\FilamentSeo;
use BackedEnum;

class SeoTagRegistry
{
    protected array $tags = [];

    public function register(RenderableSeoTag $tag, ?string $key = null): void
    {
        $tagKey = FilamentSeo::normalizeKey($key ?? $tag->key()->value);
        $this->tags[$tagKey] = $tag;
    }

    public function get(BackedEnum | string $key): ?RenderableSeoTag
    {
        $originalKey = $key instanceof BackedEnum
            ? $key->value
            : $key;

        $tagKey = FilamentSeo::normalizeKey($originalKey);

        $tag = $this->tags[$tagKey] ?? null;

        if ($tag !== null) {
            return $tag;
        }

        $handler = config('filament-seo.handler.missing_tag');

        if (filled($handler)) {
            throw new $handler(
                "SEO tag [{$originalKey}] is not registered."
            );
        }

        return null;
    }

    /**
     * @return iterable<RenderableSeoTag>
     */
    public function all(): iterable
    {
        return $this->tags;
    }

    public function getByMethod(string $method): ?RenderableSeoTag
    {
        return $this->tags[FilamentSeo::normalizeKey($method)] ?? null;
    }

    public function only(array $keys): iterable
    {
        foreach ($keys as $key) {
            $tag = $this->get($key);

            if ($tag !== null) {
                yield $tag;
            }
        }
    }
}
