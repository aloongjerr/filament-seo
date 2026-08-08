<?php

namespace AloongJerr\FilamentSeo\Contracts;

use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;

interface RenderableSeoTag
{
    public function key(): BackedEnum;
    public function render(): Htmlable;

    public function isRenderable(): bool;
}
