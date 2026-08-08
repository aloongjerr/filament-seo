<?php

use AloongJerr\FilamentSeo\Enums\SeoTagType;
use AloongJerr\FilamentSeo\Models\SeoSetting;
use AloongJerr\FilamentSeo\Models\SeoSite;
use AloongJerr\FilamentSeo\Models\SeoTag;
use AloongJerr\FilamentSeo\Tags\SeoCanonicalTag;
use AloongJerr\FilamentSeo\Tags\SeoDescriptionTag;
use AloongJerr\FilamentSeo\Tags\SeoJsonLdTag;
use AloongJerr\FilamentSeo\Tags\SeoOpenGraphTag;
use AloongJerr\FilamentSeo\Tags\SeoRobotsTag;
use AloongJerr\FilamentSeo\Tags\SeoTitleTag;
use AloongJerr\FilamentSeo\Tags\SeoTwitterCardTag;

// config for AloongJerr/FilamentSeo
return [
    /*
   |--------------------------------------------------------------------------
   | Default SEO Site
   |--------------------------------------------------------------------------
   |
   | Used when no SEO context can be resolved.
   |
   */

    'default_site' => null,

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    */

    'cache' => true,

    'handler' => [
        // Possible value: Throwable | null
        'missing_tag' => InvalidArgumentException::class,
    ],

    'models' => [
        'seo_site' => SeoSite::class,
        'seo_setting' => SeoSetting::class,
        'seo_tag' => SeoTag::class,
    ],

    'tags' => [
        SeoTagType::Title->value => SeoTitleTag::class,
        SeoTagType::Description->value => SeoDescriptionTag::class,
        SeoTagType::Robots->value => SeoRobotsTag::class,
        SeoTagType::Canonical->value => SeoCanonicalTag::class,
        SeoTagType::OpenGraph->value => SeoOpenGraphTag::class,
        SeoTagType::TwitterCard->value => SeoTwitterCardTag::class,
        SeoTagType::JsonLd->value => SeoJsonLdTag::class,
    ],
];
