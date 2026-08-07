<?php

namespace AloongJerr\FilamentSeo\Facades;

use AloongJerr\FilamentSeo\Contracts\SeoManager as SeoManagerContract;
use AloongJerr\FilamentSeo\Services\SeoManager as SeoManagerService;
use Illuminate\Support\Facades\Facade;

/**
 * @see SeoManagerService
 */
class FilamentSeo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SeoManagerContract::class;
    }
}
