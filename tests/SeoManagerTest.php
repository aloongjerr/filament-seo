<?php

use AloongJerr\FilamentSeo\Contracts\SeoManager as SeoManagerContract;
use AloongJerr\FilamentSeo\Models\SeoSetting;
use AloongJerr\FilamentSeo\Models\SeoSite;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can generate title using seo settings', function () {

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
        'default_title' => 'Homepage',
    ]);

    $title = app(SeoManagerContract::class)
        ->title('Blog');

    expect($title)
        ->toBe('My Site Blog Official');
});
