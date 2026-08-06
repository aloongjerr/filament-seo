<?php

it('can create seo site model', function () {
    expect(new \AloongJerr\FilamentSeo\Models\SeoSite())
        ->toBeInstanceOf(\Illuminate\Database\Eloquent\Model::class);
});
