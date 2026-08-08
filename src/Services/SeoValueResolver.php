<?php

namespace AloongJerr\FilamentSeo\Services;

use AloongJerr\FilamentSeo\Contracts\HasSeo;
use AloongJerr\FilamentSeo\FilamentSeo;
use BackedEnum;
use Illuminate\Database\Eloquent\Model;

class SeoValueResolver
{
    public function __construct(
        protected SeoSiteResolver $siteResolver,
    )
    {
    }

    public function resolve(
        Model $model,
        BackedEnum|string $tag,
    ): mixed
    {
        $key = $this->normalizeKey($tag);

        if ($model instanceof HasSeo) {
            // 1. Model-specific SEO value
            $value = $this->resolveModelValue($model, $key);

            if (filled($value)) {
                return $value;
            }

            // 2. Model default SEO value
            $value = $model->getDefaultSeoValue($key);

            if (filled($value)) {
                return $value;
            }
        }

        // 3. Site default SEO value
        return $this->resolveSiteValue($key);
    }

    protected function normalizeKey(BackedEnum|string $tag): string
    {
        return $tag instanceof BackedEnum
            ? FilamentSeo::normalizeKey($tag->value)
            : FilamentSeo::normalizeKey($tag);
    }

    protected function resolveModelValue(
        HasSeo $model,
        string $key,
    ): mixed
    {

        return data_get($model->seoTags?->tags, $key);
    }

    protected function resolveSiteValue(string $key): mixed
    {
        $setting = $this->siteResolver
            ->resolve()
            ?->setting;

        return data_get($setting?->tags, $key);
    }
}
