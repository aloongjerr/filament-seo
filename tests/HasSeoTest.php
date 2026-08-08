<?php

use AloongJerr\FilamentSeo\Concerns\HasSeo;
use AloongJerr\FilamentSeo\Models\SeoTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

class TestBlogPost extends Model implements AloongJerr\FilamentSeo\Contracts\HasSeo
{
    use HasSeo;
}

class CustomPage extends Model implements AloongJerr\FilamentSeo\Contracts\HasSeo
{
    use HasSeo;

    public function getDefaultSeoTitle(): ?string
    {
        return 'Custom Page Title';
    }
}

it('can get default seo title from model name', function () {
    $model = new TestBlogPost;

    expect($model->getDefaultSeoTitle())
        ->toBe('Test Blog Post');
});

it('can override default seo title', function () {
    $model = new CustomPage;

    expect($model->getDefaultSeoTitle())
        ->toBe('Custom Page Title');
});

class TestModel extends Model implements AloongJerr\FilamentSeo\Contracts\HasSeo
{
    use HasSeo;

    protected $table = 'test_models';

    protected $guarded = [];
}

it('can access seo tags through has seo relationship', function () {
    Schema::create('test_models', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
    });

    $model = TestModel::query()->create([]);

    $model->seoTags()->create([
        'tags' => [
            'title' => 'About Us',
        ],
    ]);

    expect($model->seoTags)
        ->toBeInstanceOf(SeoTag::class)
        ->and($model->seoTags->tags)
        ->toBe([
            'title' => 'About Us',
        ]);
});

class InvalidTestModel extends Model
{
    use HasSeo;

    protected $table = 'invalid_test_models';

    protected $guarded = [];
}

it('throws exception when model uses has seo trait without implementing contract', function () {
    new InvalidTestModel;
})->throws(
    LogicException::class,
    'uses the HasSeo trait but does not implement the HasSeo contract.',
);
