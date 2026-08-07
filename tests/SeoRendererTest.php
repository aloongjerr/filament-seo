<?php

use AloongJerr\FilamentSeo\Renderer\SeoTitleTagRenderer;

it('can render seo title tag', function () {

    $html = app(SeoTitleTagRenderer::class)
        ->render();

    expect($html->toHtml())
        ->toContain('<title>');

});
