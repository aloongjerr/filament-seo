<?php

use AloongJerr\FilamentSeo\Models\SeoSite;
use Illuminate\Database\Eloquent\Model;

it('can create seo site model', function () {
    expect(new SeoSite)
        ->toBeInstanceOf(Model::class);
});
