<?php

use AloongJerr\FilamentSeo\Concerns\HasSeo;
use AloongJerr\FilamentSeo\Contracts\HasSeo as HasSeoContract;
use AloongJerr\FilamentSeo\Enums\SeoTagType;
use AloongJerr\FilamentSeo\Models\SeoSetting;
use AloongJerr\FilamentSeo\Models\SeoSite;
use AloongJerr\FilamentSeo\Services\SeoValueResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

class TestSeoValueResolverModel extends Model
{
    protected $guarded = [];
}

it('falls back to site seo setting when model has no seo value', function () {
    $site = SeoSite::query()->create([
        'name' => 'Main Website',
        'domain' => request()->getHost(),
        'is_active' => true,
        'is_default' => true,
    ]);

    SeoSetting::query()->create([
        'seo_site_id' => $site->id,
        'tags' => [
            'title' => 'Default Site Title',
        ],
    ]);

    $model = new TestSeoValueResolverModel;

    $value = app(SeoValueResolver::class)->resolve(
        $model,
        SeoTagType::Title,
    );

    expect($value)->toBe('Default Site Title');
});

class TestSeoModel extends Model implements HasSeoContract
{
    use HasSeo;

    protected $guarded = [];
}

it('uses model seo value before site seo setting', function () {
    $site = SeoSite::query()->create([
        'name' => 'Main Website',
        'domain' => request()->getHost(),
        'is_active' => true,
        'is_default' => true,
    ]);

    SeoSetting::query()->create([
        'seo_site_id' => $site->id,
        'tags' => [
            'title' => 'Default Site Title',
        ],
    ]);

    Schema::create('test_seo_models', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
    });

    $model = TestSeoModel::query()->create([]);

    $model->seoTags()->create([
        'tags' => [
            'title' => 'Blog Post Title',
        ],
    ]);

    $value = app(SeoValueResolver::class)->resolve(
        $model,
        SeoTagType::Title,
    );

    expect($value)->toBe('Blog Post Title');
});

it('uses model default seo value before site seo setting', function () {
    $site = SeoSite::query()->create([
        'name' => 'Main Website',
        'domain' => request()->getHost(),
        'is_active' => true,
        'is_default' => true,
    ]);

    SeoSetting::query()->create([
        'seo_site_id' => $site->id,
        'tags' => [
            'title' => 'Default Site Title',
        ],
    ]);

    Schema::create('test_seo_models', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
    });

    $model = TestSeoModel::query()->create([]);

    $value = app(SeoValueResolver::class)->resolve(
        $model,
        SeoTagType::Title,
    );

    expect($value)->toBe('Test Seo Model');
});

class TestSeoModelWithoutDefault extends Model implements HasSeoContract
{
    use HasSeo;

    protected $guarded = [];

    public function getDefaultSeoValue(string $key): mixed
    {
        return null;
    }
}

it('falls back to site seo setting when model default seo value is empty', function () {
    $site = SeoSite::query()->create([
        'name' => 'Main Website',
        'domain' => request()->getHost(),
        'is_active' => true,
        'is_default' => true,
    ]);

    SeoSetting::query()->create([
        'seo_site_id' => $site->id,
        'tags' => [
            'title' => 'Default Site Title',
        ],
    ]);

    $model = new TestSeoModelWithoutDefault;

    $value = app(SeoValueResolver::class)->resolve(
        $model,
        SeoTagType::Title,
    );

    expect($value)->toBe('Default Site Title');
});
