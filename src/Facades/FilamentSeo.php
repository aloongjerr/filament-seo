<?php

namespace AloongJerr\FilamentSeo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AloongJerr\FilamentSeo\FilamentSeo
 */
class FilamentSeo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AloongJerr\FilamentSeo\FilamentSeo::class;
    }
}
