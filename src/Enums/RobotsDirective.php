<?php

namespace AloongJerr\FilamentSeo\Enums;

enum RobotsDirective: string
{
    case INDEX_FOLLOW = 'index,follow';
    case NOINDEX_FOLLOW = 'noindex,follow';
    case INDEX_NOFOLLOW = 'index,nofollow';
    case NOINDEX_NOFOLLOW = 'noindex,nofollow';
}
