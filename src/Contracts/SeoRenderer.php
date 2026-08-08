<?php

namespace AloongJerr\FilamentSeo\Contracts;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

interface SeoRenderer
{
    public function model(Model $model): static;

    public function getModel(): ?Model;

    public function render(): Htmlable;
}
