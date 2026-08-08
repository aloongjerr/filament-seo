<?php

namespace AloongJerr\FilamentSeo\Contracts;

use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;

interface GroupSeoTag extends RenderableSeoTag
{

    public function set(string $key, mixed $value, array $attributes = []): static;

    public function value(string $key, bool $escaped = true): mixed;
}
