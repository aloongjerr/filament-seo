<?php

namespace AloongJerr\FilamentSeo\Concerns;

use AloongJerr\FilamentSeo\Contracts\HasSeo as HasSeoContract;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use LogicException;

trait HasSeo
{
    protected static function bootHasSeo(): void
    {
        if (! is_a(static::class, HasSeoContract::class, true)) {
            throw new LogicException(
                sprintf(
                    'Model [%s] uses the HasSeo trait but does not implement the HasSeo contract.',
                    static::class,
                )
            );
        }
    }

    public function getDefaultSeoTitle(): ?string
    {
        return $this->resolveSeoTitle();
    }

    public function getDefaultSeoValue(string $key): mixed
    {
        if ($key === 'title') {
            return $this->getDefaultSeoTitle();
        }

        return null;
    }

    protected function resolveSeoTitle(): string
    {
        return str(class_basename($this))
            ->headline()
            ->toString();
    }

    public function seoTags(): MorphOne
    {
        return $this->morphOne(
            config('filament-seo.models.seo_tag'),
            'modelable',
        );
    }
}
