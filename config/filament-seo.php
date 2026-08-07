<?php

use AloongJerr\FilamentSeo\Models\SeoSetting;
use AloongJerr\FilamentSeo\Models\SeoSite;

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

    'models' => [
        'seo_site' => SeoSite::class,
        'seo_setting' => SeoSetting::class,
    ],
];
