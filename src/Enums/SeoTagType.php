<?php

namespace AloongJerr\FilamentSeo\Enums;

enum SeoTagType: string
{
    case Title = 'title';
    case Description = 'description';
    case Robots = 'robots';
    case Canonical = 'canonical';
    case OpenGraph = 'openGraph';
    case TwitterCard = 'twitterCard';
    case JsonLd = 'jsonLd';
}
