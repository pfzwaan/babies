@php($mediaId = $data['image'] ?? null)
@php($alt = $data['alt'] ?? '')

@if($mediaId)
    <figure class="mx-auto mb-8 w-full max-w-[1125px] px-4 md:px-8">
        <x-curator-glider :media="$mediaId" :alt="$alt" class="h-auto w-full rounded-[30px]" />
    </figure>
@endif
