<?php

use AloongJerr\FilamentSeo\Contracts\SeoRenderer as SeoRendererContract;
use AloongJerr\FilamentSeo\Enums\RobotsDirective;
use AloongJerr\FilamentSeo\Enums\TwitterCardType;
use AloongJerr\FilamentSeo\Models\SeoSetting;
use AloongJerr\FilamentSeo\Models\SeoSite;
use AloongJerr\FilamentSeo\Tags\SeoCanonicalTag;
use AloongJerr\FilamentSeo\Tags\SeoDescriptionTag;
use AloongJerr\FilamentSeo\Tags\SeoJsonLdTag;
use AloongJerr\FilamentSeo\Tags\SeoOpenGraphTag;
use AloongJerr\FilamentSeo\Tags\SeoRobotsTag;
use AloongJerr\FilamentSeo\Tags\SeoTitleTag;
use AloongJerr\FilamentSeo\Tags\SeoTwitterCardTag;
use Illuminate\Database\Schema\Blueprint;

it('can set and retrieve seo tag value', function () {

    $tag = app(SeoTitleTag::class);

    expect($tag->getValue())
        ->toBeNull();

    $tag->value('My Website');

    expect($tag->getValue())
        ->toBe('My Website');
});

it('is renderable when seo tag has value', function () {

    $tag = app(SeoTitleTag::class)
        ->value('My Website');

    expect($tag->isRenderable())
        ->toBeTrue();
});

it('is not renderable when seo tag has no value', function () {

    $tag = app(SeoTitleTag::class);

    expect($tag->isRenderable())
        ->toBeFalse();
});

it('can render boolean seo tag attributes', function () {

    $html = app(SeoDescriptionTag::class)
        ->value('My website description')
        ->addAttribute('defer')
        ->render();

    expect($html->toHtml())
        ->toContain('defer');
});

it('can render seo tag attributes', function () {

    $html = app(SeoDescriptionTag::class)
        ->value('My website description')
        ->addAttribute('data-source', 'cms')
        ->render();

    expect($html->toHtml())
        ->toContain('data-source="cms"');
});

it('can render multiple seo tag attributes', function () {

    $html = app(SeoDescriptionTag::class)
        ->value('My website description')
        ->addAttribute('data-test', 'description')
        ->addAttribute('data-source', 'cms')
        ->render();

    expect($html->toHtml())
        ->toContain('data-test="description"')
        ->toContain('data-source="cms"');
});

it('can exclude seo tag attributes', function () {
    $html = app(SeoDescriptionTag::class)
        ->value('My website description')
        ->addAttribute('name', 'custom')
        ->addAttribute('content', 'custom')
        ->addAttribute('data-test', 'foo')
        ->render();

    expect($html->toHtml())
        ->toContain('<meta name="description"')
        ->toContain('content="My website description"')
        ->toContain('data-test="foo"')
        ->not->toContain('name="custom"')
        ->not->toContain('content="custom"');
});

it('escapes seo tag value when rendering', function () {

    $html = app(SeoTitleTag::class)
        ->value('<script>alert("xss")</script>')
        ->render();

    expect($html->toHtml())
        ->not->toContain('<script>')
        ->toContain('&lt;script&gt;');
});

it('can render seo title tag', function () {

    $html = app(SeoTitleTag::class)
        ->value('My Website Title')
        ->render();

    expect(
        $html->toHtml()
    )
        ->toContain('<title>')
        ->toContain('My Website Title');

});

it('can render seo description tag', function () {

    $html = app(SeoDescriptionTag::class)
        ->value('My Website Description')
        ->render();

    expect(
        $html->toHtml()
    )
        ->toContain('<meta name="description"')
        ->toContain('My Website Description');

});

it('can render seo robots tag', function () {
    $html = app(SeoRobotsTag::class)
        ->value(RobotsDirective::INDEX_FOLLOW)
        ->render();

    expect($html->toHtml())
        ->toContain('<meta name="robots"')
        ->toContain('content="' . RobotsDirective::INDEX_FOLLOW->value . '"');
});

it('can render seo canonical tag', function () {

    $html = app(SeoCanonicalTag::class)
        ->value('https://example.com/page')
        ->render();

    expect($html->toHtml())
        ->toContain('<link rel="canonical" href="https://example.com/page"');
});

it('can render seo open graph tags', function () {

    $html = app(SeoOpenGraphTag::class)
        ->title('My Website')
        ->description('My website description')
        ->type('website')
        ->url('https://example.com')
        ->siteName('My Website')
        ->render();

    expect($html->toHtml())
        ->toContain('property="og:title" content="My Website"')
        ->toContain('property="og:description" content="My website description"')
        ->toContain('property="og:type" content="website"')
        ->toContain('property="og:url" content="https://example.com"')
        ->toContain('property="og:site_name" content="My Website"');
});

it('can render seo open graph type from backed enum', function () {

    enum OpenGraphType: string
    {
        case Website = 'website';
    }

    $html = app(SeoOpenGraphTag::class)
        ->type(OpenGraphType::Website)
        ->render();

    expect($html->toHtml())
        ->toContain('property="og:type" content="website"');
});

it('can render seo open graph image attributes', function () {

    $html = app(SeoOpenGraphTag::class)
        ->image('https://example.com/image.jpg', [
            'width' => '1200',
            'height' => '630',
        ])
        ->render();

    expect($html->toHtml())
        ->toContain('property="og:image" content="https://example.com/image.jpg"')
        ->toContain('width="1200"')
        ->toContain('height="630"');
});

it('can render seo open graph article tags', function () {

    $html = app(SeoOpenGraphTag::class)
        ->article('published_time', '2026-08-07T12:00:00+08:00')
        ->article('section', 'Technology')
        ->render();

    expect($html->toHtml())
        ->toContain(
            'property="article:published_time" content="2026-08-07T12:00:00+08:00"'
        )
        ->toContain(
            'property="article:section" content="Technology"'
        );
});

it('can render custom seo open graph tags', function () {

    $html = app(SeoOpenGraphTag::class)
        ->set('custom_property', 'custom value')
        ->render();

    expect($html->toHtml())
        ->toContain(
            'property="og:custom_property" content="custom value"'
        );
});

it('is not renderable when seo open graph has no tags', function () {

    $tag = app(SeoOpenGraphTag::class);

    expect($tag->isRenderable())
        ->toBeFalse();
});

it('is renderable when seo open graph has tags', function () {

    $tag = app(SeoOpenGraphTag::class)
        ->title('My Website');

    expect($tag->isRenderable())
        ->toBeTrue();
});

it('can render seo twitter card tags', function () {

    $html = app(SeoTwitterCardTag::class)
        ->card('summary')
        ->site('@example')
        ->creator('@author')
        ->title('My Website')
        ->description('My website description')
        ->image('https://example.com/image.jpg')
        ->render();

    expect($html->toHtml())
        ->toContain('<meta name="twitter:card" content="summary"')
        ->toContain('<meta name="twitter:site" content="@example"')
        ->toContain('<meta name="twitter:creator" content="@author"')
        ->toContain('<meta name="twitter:title" content="My Website"')
        ->toContain('<meta name="twitter:description" content="My website description"')
        ->toContain('<meta name="twitter:image" content="https://example.com/image.jpg"');
});

it('can render seo twitter card type from backed enum', function () {

    $html = app(SeoTwitterCardTag::class)
        ->card(TwitterCardType::Summary)
        ->render();

    expect($html->toHtml())
        ->toContain('name="twitter:card"')
        ->toContain('content="' . TwitterCardType::Summary->value . '"');
});

it('can render seo twitter card image attributes', function () {

    $html = app(SeoTwitterCardTag::class)
        ->image(
            'https://example.com/image.jpg',
            ['data-source' => 'cms']
        )
        ->render();

    expect($html->toHtml())
        ->toContain('content="https://example.com/image.jpg"')
        ->toContain('data-source="cms"');
});

it('can render seo json ld tags', function () {

    $html = app(SeoJsonLdTag::class)
        ->set('@context', 'https://schema.org')
        ->set('@type', 'WebSite')
        ->set('name', 'My Website')
        ->set('url', 'https://example.com')
        ->render();

    expect($html->toHtml())
        ->toContain('<script type="application/ld+json">')
        ->toContain('"@context":"https://schema.org"')
        ->toContain('"@type":"WebSite"')
        ->toContain('"name":"My Website"')
        ->toContain('"url":"https://example.com"')
        ->toContain('</script>');
});

it('can render nested seo json ld data', function () {

    $html = app(SeoJsonLdTag::class)
        ->set('@context', 'https://schema.org')
        ->set('@type', 'Article')
        ->set('author', [
            '@type' => 'Person',
            'name' => 'John Doe',
        ])
        ->render();

    expect($html->toHtml())
        ->toContain('"author":{"@type":"Person","name":"John Doe"}');
});

it('is not renderable when seo json ld has no tags', function () {

    expect(app(SeoJsonLdTag::class)->isRenderable())
        ->toBeFalse();
});

it('is renderable when seo json ld has tags', function () {

    expect(
        app(SeoJsonLdTag::class)
            ->set('@type', 'WebSite')
            ->isRenderable()
    )->toBeTrue();
});

it('can set and retrieve seo model context', function () {
    $model = new TestModel;

    $renderer = app(SeoRendererContract::class);

    expect($renderer->model($model))
        ->toBe($renderer)
        ->and($renderer->getModel())
        ->toBe($model);
});

it('can render seo tag value from model context', function () {
    $site = SeoSite::query()->create([
        'name' => 'Main Website',
        'domain' => request()->getHost(),
        'is_active' => true,
        'is_default' => true,
    ]);

    SeoSetting::query()->create([
        'seo_site_id' => $site->id,
        'tags' => [
            'title' => 'Default Site Title',
        ],
    ]);

    Schema::create('test_seo_models', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
    });

    $model = TestSeoModel::query()->create([]);

    $model->seoTags()->create([
        'tags' => [
            'title' => 'Blog Post Title',
        ],
    ]);

    $html = app(SeoRendererContract::class)
        ->model($model)
        ->render()
        ->toHtml();

    expect($html)->toContain('<title>Blog Post Title</title>');
});
