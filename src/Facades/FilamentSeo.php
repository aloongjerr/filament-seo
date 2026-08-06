<?php

namespace AloongJerr\FilamentSeo\Facades;

use AloongJerr\FilamentSeo\Services\SeoManager;
use Illuminate\Support\Facades\Facade;

/**
 * @see \AloongJerr\FilamentSeo\FilamentSeo
 */
class FilamentSeo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SeoManager::class;
    }
}
