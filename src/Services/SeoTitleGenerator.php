<?php

namespace AloongJerr\FilamentSeo\Services;

class SeoTitleGenerator
{
    public function __construct(
        protected SeoSiteResolver $resolver,
    ) {}

    public function generate(?string $title = null): string
    {
        $site = $this->resolver->resolve();

        if (! $site?->setting) {
            return $title ?? '';
        }

        $setting = $site->setting;

        return trim(
            collect([
                $setting->title_prefix,
                $title ?: $setting->default_title,
                $setting->title_suffix,
            ])
                ->filter()
                ->implode(' ')
        );
    }
}
