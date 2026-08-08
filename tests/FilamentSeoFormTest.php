<?php

use AloongJerr\FilamentSeo\Enums\SeoTagType;
use AloongJerr\FilamentSeo\Filament\Forms\FilamentSeoForm;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

it('can get seo form schema', function () {
    $schema = FilamentSeoForm::make()->schema();

    expect($schema)
        ->toBeArray()
        ->not->toBeEmpty();
});

it('includes seo title form schema', function () {
    $schema = FilamentSeoForm::make()->schema();

    expect(
        collect($schema)->contains(
            fn ($component) => $component instanceof TextInput
        )
    )->toBeTrue();
});

it('includes seo group form schema', function () {
    $schema = FilamentSeoForm::make()->schema();

    expect(
        collect($schema)->contains(
            fn ($component) => $component instanceof Section
        )
    )->toBeTrue();
});

it('can get form schema for specific seo tags', function () {
    $schema = FilamentSeoForm::make()
        ->tags([
            SeoTagType::Title,
        ])
        ->schema();

    expect($schema)
        ->toHaveCount(1)
        ->and($schema[0])
        ->toBeInstanceOf(TextInput::class);
});

it('can get form schema for specific seo tags using string keys', function () {
    $schema = FilamentSeoForm::make()
        ->tags([
            'title',
        ])
        ->schema();

    expect($schema)
        ->toHaveCount(1)
        ->and($schema[0])
        ->toBeInstanceOf(TextInput::class);
});
