<?php

namespace AloongJerr\FilamentSeo\Contracts;

use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

interface SeoManager
{
    public function model(Model $model): static;

    public function tag(BackedEnum | string $type): ?RenderableSeoTag;

    public function render(): Htmlable;
}
