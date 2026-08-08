<?php

namespace AloongJerr\FilamentSeo\Contracts;

use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;

interface SeoTag extends RenderableSeoTag
{

    public function value(mixed $value): mixed;

    public function getValue(bool $escaped = true): mixed;
}
