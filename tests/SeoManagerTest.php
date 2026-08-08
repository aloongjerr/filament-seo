<?php

use AloongJerr\FilamentSeo\Contracts\SeoManager as SeoManagerContract;
use AloongJerr\FilamentSeo\Contracts\SeoRenderer as SeoRendererContract;
use AloongJerr\FilamentSeo\Enums\SeoTagType;
use AloongJerr\FilamentSeo\Models\SeoSetting;
use AloongJerr\FilamentSeo\Models\SeoSite;
use AloongJerr\FilamentSeo\Registry\SeoTagRegistry;
use AloongJerr\FilamentSeo\Services\SeoManager;
use AloongJerr\FilamentSeo\Tags\SeoOpenGraphTag;
use AloongJerr\FilamentSeo\Tags\SeoTitleTag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can render seo title using seo settings', function () {

    $site = SeoSite::create([
        'name' => 'Main Site',
        'domain' => 'example.com',
        'is_default' => true,
        'is_active' => true,
    ]);

    SeoSetting::create([
        'seo_site_id' => $site->getKey(),
        'title_prefix' => 'My Site',
        'title_suffix' => 'Official',
        'tags' => [
            'title' => 'Homepage',
        ],
    ]);

    $html = app(SeoManagerContract::class)
        ->title()
        ->value('Blog')
        ->render();

    expect($html->toHtml())
        ->toContain('<title>')
        ->toContain('Blog');
});

it('can resolve seo tag using tag method', function () {
    $tag = seo()->tag(SeoTagType::Title);

    expect($tag)
        ->toBeInstanceOf(SeoTitleTag::class);
});

it('can resolve seo tag using tag method with string', function () {
    $tag = seo()->tag(SeoTagType::Title->value);

    expect($tag)
        ->toBeInstanceOf(SeoTitleTag::class);
});

it('can resolve custom seo tag using tag method', function () {
    $tag = seo()->tag('title');

    expect($tag)
        ->toBeInstanceOf(SeoTitleTag::class);
});

it('returns null when seo tag is not registered using tag method', function () {
    config()->set('filament-seo.handler.missing_tag', null);

    expect(
        seo()->tag('missing_tag')
    )->toBeNull();
});

it('throws exception when seo tag is not registered using tag method', function () {
    config()->set(
        'filament-seo.handler.missing_tag',
        BadMethodCallException::class
    );

    expect(fn () => seo()->tag('missing_tag'))
        ->toThrow(
            BadMethodCallException::class,
            'SEO tag [missing_tag] is not registered.'
        );
});

it('can resolve seo tag using dynamic method', function () {

    expect(seo()->title())
        ->toBeInstanceOf(SeoTitleTag::class);

});

it('can resolve group seo tag using dynamic method', function () {

    expect(seo()->openGraph())
        ->toBeInstanceOf(SeoOpenGraphTag::class);

});

it('can resolve seo tag using normalized dynamic method', function () {

    expect(seo()->open_graph())
        ->toBeInstanceOf(SeoOpenGraphTag::class);

});

it('throws exception when seo tag method is not registered', function () {

    seo()->foo();

})->throws(
    BadMethodCallException::class,
    'SEO tag method [foo] is not registered.'
);

it('can resolve custom seo tag using dynamic method', function () {

    $registry = app(SeoTagRegistry::class);

    $tag = app(SeoTitleTag::class);

    $registry->register($tag, 'customTag');

    expect(
        seo()->customTag()
    )->toBe($tag);
});

it('can resolve custom seo tag using normalized custom key', function () {

    $registry = app(SeoTagRegistry::class);

    $tag = app(SeoTitleTag::class);

    $registry->register($tag, 'my_custom_tag');

    expect(
        seo()->my_custom_tag()
    )->toBe($tag);
});

it('can resolve custom seo tag using normalized dynamic method', function () {

    $registry = app(SeoTagRegistry::class);

    $tag = app(SeoTitleTag::class);

    $registry->register($tag, 'my_custom_tag');

    expect(seo()->my_custom_tag())
        ->toBe($tag);

    expect(seo()->myCustomTag())
        ->toBe($tag);
});

it('can set seo model context on renderer', function () {
    $model = new TestModel;

    $renderer = Mockery::mock(SeoRendererContract::class);

    $renderer
        ->shouldReceive('model')
        ->once()
        ->with($model)
        ->andReturnSelf();

    $manager = new SeoManager(
        app(SeoTagRegistry::class),
        $renderer,
    );

    expect($manager->model($model))
        ->toBe($manager);
});
