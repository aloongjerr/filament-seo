<?php

namespace AloongJerr\FilamentSeo;

class FilamentSeo
{
    public static function normalizeKey(string $key): string
    {
        return str($key)->camel()->toString();
    }
}
