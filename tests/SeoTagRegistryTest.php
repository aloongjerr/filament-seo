<?php

use AloongJerr\FilamentSeo\Enums\SeoTagType;
use AloongJerr\FilamentSeo\Registry\SeoTagRegistry;
use AloongJerr\FilamentSeo\Tags\SeoTitleTag;

it('can resolve seo tags from config', function () {
    /**
     * @var SeoTagRegistry $registry
     */
    $registry = app(SeoTagRegistry::class);

    expect(
        $registry->get(SeoTagType::Title)
    )
        ->toBeInstanceOf(
            SeoTitleTag::class
        );
});

enum CustomTag: string
{
    case MissingTag = 'missing_tag';
}

it('throws exception when seo tag is not registered', function () {

    app(SeoTagRegistry::class)
        ->get(CustomTag::MissingTag);

})->throws(
    InvalidArgumentException::class,
    'SEO tag [missing_tag] is not registered.'
);

it('returns null when seo tag is not registered and handler is disabled', function () {

    config()->set('filament-seo.handler.missing_tag', null);

    expect(
        app(SeoTagRegistry::class)
            ->get(CustomTag::MissingTag)
    )->toBeNull();

});
