<?php

use AloongJerr\FilamentSeo\Tags\SeoOpenGraphTag;
use AloongJerr\FilamentSeo\Tags\SeoTitleTag;
use Filament\Schemas\Components\Section;

it('can get seo title form schema', function () {
    $tag = app(SeoTitleTag::class);

    expect($tag->getFormSchema())
        ->toBeArray()
        ->toHaveCount(1);
});

it('can get seo open graph form schema', function () {
    $tag = app(SeoOpenGraphTag::class);

    $schema = $tag->getFormSchema();

    expect($schema)
        ->toBeArray()
        ->toHaveCount(1)
        ->and($schema[0])
        ->toBeInstanceOf(Section::class);
});
