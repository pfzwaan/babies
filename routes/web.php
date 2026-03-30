<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\NameController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

$languageSlugPattern = '(' . implode('|', array_map(static fn (string $slug) => preg_quote($slug, '/'), array_keys(config('name_languages', [])))) . ')';
$specialTagPattern = '(' . implode('|', array_map(static fn (string $slug) => preg_quote($slug, '/'), collect(config('name_special_tags', []))->flatMap(static fn (array $tag) => $tag['matches'] ?? [])->unique()->values()->all())) . ')';

Route::get('/', [PageController::class, 'home']);

Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{slug}', [BlogController::class, 'show'])
    ->where('slug', '[A-Za-z0-9-]+');

Route::get('/namen', [NameController::class, 'archiveGlobal'])->name('names.archive');
Route::get('/namen/zoeken', [NameController::class, 'search'])->name('names.search');
Route::get('/namen/{nameCategory}', function ($nameCategory) {
    return redirect()->route('names.category', ['nameCategory' => $nameCategory], 301);
})->name('names.category.legacy');
Route::get('/namen/{nameCategory}/{genderSlug}', function ($nameCategory, $genderSlug) {
    return redirect()->route('names.category.gender', ['nameCategory' => $nameCategory, 'genderSlug' => $genderSlug], 301);
})
    ->where('genderSlug', '(reu|rue|teef|teefje|mannelijk|vrouwelijk|male|female)')
    ->name('names.category.gender.legacy');
Route::get('/namen/{nameCategory}/{letter}', function ($nameCategory, $letter) {
    return redirect()->route('names.category.letter', ['nameCategory' => $nameCategory, 'letter' => $letter], 301);
})
    ->where('letter', '[A-Za-z]')
    ->name('names.category.letter.legacy');
Route::get('/namen/{nameCategory}/{name}', function ($nameCategory, $name) {
    return redirect()->route('names.show', ['nameCategory' => $nameCategory, 'name' => $name], 301);
})
    ->where('name', '(?![A-Za-z]$)[A-Za-z0-9-]+')
    ->name('names.show.legacy');
Route::get('/namen/{nameCategory}/{tagGroup}/{tag}', function ($nameCategory, $tagGroup, $tag) {
    return redirect()->route('names.category.tag', [
        'nameCategory' => $nameCategory,
        'tagGroup' => $tagGroup,
        'tag' => $tag,
    ], 301);
})
    ->where('tagGroup', '[A-Za-z0-9-]+')
    ->where('tag', '[A-Za-z0-9-]+')
    ->name('names.category.tag.legacy');
Route::post('/namen/{nameCategory}/{name}/like', [NameController::class, 'like'])
    ->where('name', '(?![A-Za-z]$)[A-Za-z0-9-]+')
    ->name('names.like.legacy');
Route::post('/namen/{nameCategory}/{name}/comments', [NameController::class, 'storeComment'])
    ->where('name', '(?![A-Za-z]$)[A-Za-z0-9-]+')
    ->name('names.comments.store.legacy');

Route::get('/{nameCategory}', [NameController::class, 'categoryIndex'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->name('names.category');
Route::get('/{nameCategory}/{segment}/{letter}', [NameController::class, 'resolveCategorySegmentLetter'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->where('segment', '[A-Za-z0-9-]+')
    ->where('letter', '[A-Za-z]')
    ->name('names.segment.letter.resolve');
Route::get('/{nameCategory}/{segment}', [NameController::class, 'resolveCategorySegment'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->where('segment', '(?![A-Za-z]$)[A-Za-z0-9-]+|[A-Za-z]')
    ->name('names.segment.resolve');
Route::get('/{nameCategory}/{tagSlug}', [NameController::class, 'categoryBySpecialTag'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->where('tagSlug', $specialTagPattern)
    ->name('names.category.tag.single');
Route::get('/{nameCategory}/{tagSlug}/{letter}', [NameController::class, 'categoryBySpecialTagLetter'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->where('tagSlug', $specialTagPattern)
    ->where('letter', '[A-Za-z]')
    ->name('names.category.tag.single.letter');
Route::get('/{nameCategory}/{languageSlug}', [NameController::class, 'categoryByLanguage'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->where('languageSlug', $languageSlugPattern)
    ->name('names.category.language');
Route::get('/{nameCategory}/{languageSlug}/{letter}', [NameController::class, 'categoryByLanguageLetter'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->where('languageSlug', $languageSlugPattern)
    ->where('letter', '[A-Za-z]')
    ->name('names.category.language.letter');
Route::get('/{nameCategory}/{genderSlug}', [NameController::class, 'categoryByGender'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->where('genderSlug', '(reu|rue|teef|teefje|mannelijk|vrouwelijk|male|female)')
    ->name('names.category.gender');
Route::get('/{nameCategory}/{letter}', [NameController::class, 'category'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->where('letter', '[A-Za-z]')
    ->name('names.category.letter');
Route::get('/{nameCategory}/{tagGroup}/{tag}', [NameController::class, 'categoryByTag'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->where('tagGroup', '[A-Za-z0-9-]+')
    ->where('tag', '[A-Za-z0-9-]+')
    ->name('names.category.tag');
Route::get('/{nameCategory}/{name}', [NameController::class, 'show'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->where('name', '(?![A-Za-z]$)[A-Za-z0-9-]+')
    ->name('names.show');
Route::post('/{nameCategory}/{name}/like', [NameController::class, 'like'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->where('name', '(?![A-Za-z]$)[A-Za-z0-9-]+')
    ->name('names.like');
Route::post('/{nameCategory}/{name}/comments', [NameController::class, 'storeComment'])
    ->where('nameCategory', '^(?!admin$)[A-Za-z0-9-]+$')
    ->where('name', '(?![A-Za-z]$)[A-Za-z0-9-]+')
    ->name('names.comments.store');

Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '^(?!admin$)[A-Za-z0-9-]+$');
