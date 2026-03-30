@php
    $defaultCategory = \App\Models\NameCategory::query()
        ->forSite(\App\Models\Site::resolveCurrent()?->id)
        ->orderBy('name')
        ->first(['slug']);

    $title = $data['title'] ?? 'Namen op alfabet';
    $lettersInput = $data['letters'] ?? [];
    $defaultLabels = range('A', 'Z');
    $letters = [];

    for ($i = 0; $i < 26; $i++) {
        $label = strtoupper((string) ($lettersInput[$i]['label'] ?? $defaultLabels[$i]));
        $label = preg_match('/^[A-Z]$/', $label) ? $label : $defaultLabels[$i];
        $customUrl = trim((string) ($lettersInput[$i]['url'] ?? ''));

        $defaultUrl = $defaultCategory
            ? route('names.category.letter', ['nameCategory' => $defaultCategory->slug, 'letter' => strtolower($label)])
            : route('names.archive');

        $letters[$i] = [
            'label' => $label,
            'url' => ($customUrl !== '' && $customUrl !== '#') ? $customUrl : $defaultUrl,
        ];
    }
@endphp

<section class="babies-alphabet">
    <div class="container px-3 lg:px-0 mx-auto babies-alphabet__panel">
        <h2 class="babies-alphabet__title">{{ $title }}</h2>

        <div class="babies-alphabet__grid">
            @foreach($letters as $index => $letter)
                <a href="{{ $letter['url'] }}" class="babies-letter {{ $index === 0 ? 'babies-letter--active' : '' }}">
                    {{ $letter['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</section>


