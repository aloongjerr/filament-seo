<?php

namespace AloongJerr\FilamentSeo\Services;

use AloongJerr\FilamentSeo\Models\SeoSite;

class SeoSiteResolver
{
    public function resolve(?string $domain = null): ?SeoSite
    {
        $domain ??= request()->getHost();

        return SeoSite::query()
            ->active()
            ->where('domain', $domain)
            ->first()
            ?? SeoSite::query()
                ->active()
                ->default()
                ->first();
    }
}
