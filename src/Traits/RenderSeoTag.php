<?php

namespace AloongJerr\FilamentSeo\Traits;

use Illuminate\Support\HtmlString;

trait RenderSeoTag
{
    protected ?string $value = null;

    public function render(): HtmlString
    {
        return new HtmlString(
            $this->tag(
                $this->value()
            )
        );
    }

    abstract protected function value(): string;

    abstract protected function tag(string $value): string;

    abstract protected function setValue(string $value): void;
}
