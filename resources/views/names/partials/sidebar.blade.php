<aside class="space-y-10 lg:col-span-4 xl:col-span-3">
    @php
        if (! isset($blogItems) || blank($blogItems)) {
            $recentBlogs = \App\Models\Blog::query()
                ->where('status', 'published')
                ->latest('published_at')
                ->latest('id')
                ->limit(3)
                ->get(['title', 'slug', 'thumbnail', 'excerpt', 'content']);

            $blogItems = $recentBlogs->map(function ($blog) {
                $thumbnailUrl = $blog->thumbnail
                    ? optional(\Awcodes\Curator\Models\Media::find($blog->thumbnail))->url
                    : null;

                return [
                    'title' => $blog->title,
                    'url' => url('/blog/' . $blog->slug),
                    'image' => $thumbnailUrl ?: 'img/figma/26909-247.png',
                ];
            })->all();
        }

        $blogItems = collect($blogItems)
            ->map(fn ($item) => is_array($item) ? $item : (array) $item)
            ->values()
            ->all();
    @endphp

    <!-- from figma: 26909:249 -->
    <div>
        <h2 class="text-center font-fredoka text-[30px] font-medium leading-[30px]">{{ $title }}</h2>

        @if(!empty($ctaUrl))
            <a href="{{ $ctaUrl }}" class="mt-6 flex h-[60px] w-full items-center justify-center gap-3 rounded-[100px] bg-coral px-5 text-center text-[17px] font-semibold text-white">
                {{ $ctaText }}
                <img src="{{ asset('img/figma/26909-233.svg') }}" alt="" aria-hidden="true" class="h-3.5 w-4" />
            </a>
        @else
            <button type="button" class="mt-6 flex h-[60px] w-full items-center justify-center gap-3 rounded-[100px] bg-coral px-5 text-center text-[17px] font-semibold text-white">
                {{ $ctaText }}
                <img src="{{ asset('img/figma/26909-233.svg') }}" alt="" aria-hidden="true" class="h-3.5 w-4" />
            </button>
        @endif

        <div class="mt-6 rounded-[30px] bg-lime p-[15px]">
            <div class="rounded-[30px] bg-white px-7 py-8">
                <ul class="space-y-3 text-[24px] md:text-[28px] md:leading-[60px]">
                    @forelse($items as $item)
                        @php($itemCategory = ($nameCategory ?? null) ?: ($item->nameCategory ?? null))
                        <li class="flex items-center gap-3">
                            <span class="inline-flex h-[39px] w-[39px] items-center justify-center rounded-full bg-ink">
                                <img src="{{ asset('img/figma/26909-199.svg') }}" alt="" aria-hidden="true" class="h-[18px] w-[18px]" />
                            </span>
                            @if($itemCategory)
                                <a href="{{ route('names.show', ['nameCategory' => $itemCategory, 'name' => $item]) }}">{{ $item->title }}</a>
                            @else
                                <span>{{ $item->title }}</span>
                            @endif
                        </li>
                    @empty
                        <li class="text-[18px] leading-[30px]">{{ $emptyText ?? 'Nog geen namen beschikbaar.' }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- from figma: 26909:235 -->
    <section class="rounded-[30px] bg-panel p-[23px]">
        <h3 class="font-fredoka text-[32px] font-medium leading-[40px]">Recente blogberichten</h3>
        <div class="mt-10 space-y-6">
            @foreach($blogItems as $index => $blogItem)
                <article>
                    @php($postImage = \Illuminate\Support\Arr::get($blogItem, 'image', 'img/figma/26909-247.png'))
                    @php($postImageSrc = \Illuminate\Support\Str::startsWith((string) $postImage, ['http://', 'https://']) ? $postImage : (file_exists(public_path((string) $postImage)) ? asset((string) $postImage) : asset('img/figma/26909-247.png')))
                    <a href="{{ \Illuminate\Support\Arr::get($blogItem, 'url', '#') }}" class="flex gap-3">
                        <img src="{{ $postImageSrc }}" alt="" class="h-[75px] w-[104px] rounded-[10px] object-cover" />
                        <p class="font-fredoka text-[18px] font-medium leading-[25px] text-black">{{ \Illuminate\Support\Arr::get($blogItem, 'title', '') }}</p>
                    </a>
                </article>
                @if($index < count($blogItems) - 1)
                    <div class="h-px w-full bg-[#e2e2e2]"></div>
                @endif
            @endforeach
        </div>
    </section>
</aside>
