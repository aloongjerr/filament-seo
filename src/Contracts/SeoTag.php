<?php

namespace AloongJerr\FilamentSeo\Contracts;

interface SeoTag extends RenderableSeoTag
{
    public function value(mixed $value): mixed;

    public function getValue(bool $escaped = true): mixed;
}
