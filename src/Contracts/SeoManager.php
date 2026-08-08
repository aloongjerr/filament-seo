<?php

namespace AloongJerr\FilamentSeo\Contracts;

use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;

interface SeoManager
{
    public function tag(BackedEnum | string $type): ?RenderableSeoTag;

    public function render(): Htmlable;
}
