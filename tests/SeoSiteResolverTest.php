<?php

use AloongJerr\FilamentSeo\Models\SeoSite;
use AloongJerr\FilamentSeo\Services\SeoSiteResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can resolve seo site by domain', function () {

    SeoSite::create([
        'name' => 'Main Website',
        'domain' => 'example.com',
        'is_default' => true,
        'is_active' => true,
    ]);

    $site = app(SeoSiteResolver::class)
        ->resolve('example.com');

    expect($site)
        ->toBeInstanceOf(SeoSite::class)
        ->and($site->domain)
        ->toBe('example.com');

});


it('falls back to default seo site when domain not found', function () {

    SeoSite::create([
        'name' => 'Main Website',
        'domain' => 'example.com',
        'is_default' => true,
        'is_active' => true,
    ]);

    $site = app(SeoSiteResolver::class)
        ->resolve('unknown.com');

    expect($site)
        ->toBeInstanceOf(SeoSite::class)
        ->and($site->domain)
        ->toBe('example.com');

});


it('does not resolve inactive seo site', function () {

    SeoSite::create([
        'name' => 'Inactive Site',
        'domain' => 'example.com',
        'is_default' => false,
        'is_active' => false,
    ]);

    $site = app(SeoSiteResolver::class)
        ->resolve('example.com');

    expect($site)
        ->toBeNull();

});
