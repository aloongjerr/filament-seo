<?php

use AloongJerr\FilamentSeo\Contracts\SeoManager;

it('can resolve seo manager', function () {
    expect(app(SeoManager::class))
        ->toBeInstanceOf(AloongJerr\FilamentSeo\Services\SeoManager::class);
});
