<?php

namespace AloongJerr\FilamentSeo\Contracts;

interface GroupSeoTag extends RenderableSeoTag
{
    public function set(string $key, mixed $value, array $attributes = []): static;

    public function value(string $key, bool $escaped = true): mixed;
}
