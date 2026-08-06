<?php

it('can resolve seo manager', function () {
    expect(app(\AloongJerr\FilamentSeo\Services\SeoManager::class))
        ->toBeInstanceOf(\AloongJerr\FilamentSeo\Services\SeoManager::class);
});
