<?php

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
        'seo_site' => \AloongJerr\FilamentSeo\Models\SeoSite::class,
        'seo_setting' => \AloongJerr\FilamentSeo\Models\SeoSetting::class,
    ]
];
