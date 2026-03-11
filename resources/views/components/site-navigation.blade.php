@php($items = $navigation?->resolvedItems() ?? [])

@if($items !== [])
    <nav class="{{ $class }}" aria-label="Site navigation">
        <ul class="flex flex-wrap items-center gap-4">
            @foreach($items as $item)
                <li class="relative">
                    <a
                        href="{{ $item['url'] }}"
                        @if($item['open_in_new_tab']) target="_blank" rel="noopener noreferrer" @endif
                        class="inline-flex items-center gap-2 text-sm font-medium text-slate-800 hover:text-slate-950"
                    >
                        {{ $item['label'] }}
                    </a>

                    @if(($item['children'] ?? []) !== [])
                        <ul class="mt-2 space-y-1 pl-4">
                            @foreach($item['children'] as $child)
                                <li>
                                    <a
                                        href="{{ $child['url'] }}"
                                        @if($child['open_in_new_tab']) target="_blank" rel="noopener noreferrer" @endif
                                        class="text-sm text-slate-600 hover:text-slate-900"
                                    >
                                        {{ $child['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
@endif
