<?php

use AloongJerr\FilamentSeo\Contracts\SeoManager as SeoManagerContract;
use AloongJerr\FilamentSeo\Services\SeoManager as SeoManagerService;

if (! function_exists('seo')) {
    function seo(): SeoManagerService
    {
        return app(SeoManagerContract::class);
    }
}
