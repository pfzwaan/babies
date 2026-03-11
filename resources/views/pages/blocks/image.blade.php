@php($mediaId = $data['image'] ?? null)
@php($alt = $data['alt'] ?? '')

@if($mediaId)
    <figure class="mb-6">
        <x-curator-glider
            :media="$mediaId"
            :alt="$alt"
            class="h-auto w-full rounded-xl"
        />
    </figure>
@endif
