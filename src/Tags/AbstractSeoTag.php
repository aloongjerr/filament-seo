<?php

namespace AloongJerr\FilamentSeo\Tags;

use AloongJerr\FilamentSeo\Concerns\HasSeoAttributes;
use AloongJerr\FilamentSeo\Contracts\HasSeoFormSchema;
use AloongJerr\FilamentSeo\Contracts\SeoTag;
use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;

abstract class AbstractSeoTag implements HasSeoFormSchema, SeoTag
{
    use HasSeoAttributes;

    protected mixed $value = null;

    public function value(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(bool $escaped = true): mixed
    {
        if (is_null($this->value)) {
            return $this->value;
        }

        return $escaped ? e($this->value) : $this->value;
    }

    public function isRenderable(): bool
    {
        return filled($this->value);
    }

    protected function formSchema(): array
    {
        return [];
    }

    public function getFormSchema(): array
    {
        return $this->formSchema();
    }

    abstract public function key(): BackedEnum;

    abstract public function render(): Htmlable;
}
