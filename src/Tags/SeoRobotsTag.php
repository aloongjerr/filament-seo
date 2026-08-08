<?php

namespace AloongJerr\FilamentSeo\Tags;

use AloongJerr\FilamentSeo\Enums\SeoTagType;
use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class SeoRobotsTag extends AbstractSeoTag
{
    public function key(): BackedEnum
    {
        return SeoTagType::Robots;
    }

    public function render(): Htmlable
    {
        return new HtmlString(
            $this->bindAttributes(
                sprintf(
                    '<meta name="robots" content="%s"@attributes/>',
                    $this->getValue()
                ),
                ['name', 'content']
            )
        );
    }
}
