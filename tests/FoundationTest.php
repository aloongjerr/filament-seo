<?php

it('can resolve seo manager', function () {
    expect(app(\AloongJerr\FilamentSeo\Contracts\SeoManager::class))
        ->toBeInstanceOf(\AloongJerr\FilamentSeo\Services\SeoManager::class);
});
