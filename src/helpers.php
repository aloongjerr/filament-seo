<?php

use AloongJerr\FilamentSeo\Services\SeoManager;

if (! function_exists('seo')) {
    /**
     * @return SeoManager
     */
    function seo(): SeoManager
    {
        return app(SeoManager::class);
    }
}
