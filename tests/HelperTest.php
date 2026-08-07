<?php

use AloongJerr\FilamentSeo\Contracts\SeoManager as SeoManagerContract;

it('can use seo helper', function () {

    expect(seo())
        ->toBeInstanceOf(SeoManagerContract::class);
});
