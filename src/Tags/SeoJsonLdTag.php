<?php

namespace AloongJerr\FilamentSeo\Tags;

use AloongJerr\FilamentSeo\Enums\SeoTagType;
use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;

class SeoJsonLdTag extends AbstractGroupSeoTag
{
    public function key(): BackedEnum
    {
        return SeoTagType::JsonLd;
    }

    public function render(): Htmlable
    {
        return view('filament-seo::tags.json-ld', [
            'tags' => $this->tags,
        ]);
    }

    protected function formSchema(): array
    {
        return [

        ];
    }
}
