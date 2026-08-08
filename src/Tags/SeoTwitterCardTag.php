<?php

namespace AloongJerr\FilamentSeo\Tags;

use AloongJerr\FilamentSeo\Enums\SeoTagType;
use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class SeoTwitterCardTag extends AbstractGroupSeoTag
{
    public function key(): BackedEnum
    {
        return SeoTagType::TwitterCard;
    }

    public function card(BackedEnum | string $value): static
    {
        if ($value instanceof BackedEnum) {
            $value = $value->value;
        }

        return $this->set('card', $value);
    }

    public function site(string $value): static
    {
        return $this->set('site', $value);
    }

    public function creator(string $value): static
    {
        return $this->set('creator', $value);
    }

    public function title(string $value): static
    {
        return $this->set('title', $value);
    }

    public function description(string $value): static
    {
        return $this->set('description', $value);
    }

    public function image(string $value, array $attributes = []): static
    {
        return $this->set('image', $value, $attributes);
    }

    public function render(): Htmlable
    {
        $tags = collect($this->tags)
            ->sortKeys();

        return new HtmlString(
            $tags
                ->map(fn ($value, $key) => $this->bindAttributes(
                    $key,
                    sprintf(
                        '<meta name="twitter:%s" content="%s"@attributes/>',
                        $key,
                        $this->value($key),
                    ),
                    ['name', 'content']
                ))
                ->implode("\n")
        );
    }
}
