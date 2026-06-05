<div class="content_page__partners">

    @if($item->img)
        <div class="content_page__img partner__logo">
            <x-picture.responsive
                :sizes="['480x320', '768x512', '1200x800']"
                :src="$item->img"
                :alt="$item->title"
            />
        </div>
    @endif

    @if($item->html)
        <x-admin.inline-edit :model="$item" field="html" label="HTML (верх)">
            <div class="content_page__html">
                {!! $item->html !!}
            </div>
        </x-admin.inline-edit>
    @endif

    @if($item->desc)
        <x-admin.inline-edit :model="$item" field="desc" label="Описание">
            <div class="content_page__desc desc">
                {!! $item->desc !!}
            </div>
        </x-admin.inline-edit>
    @endif

    @if($item->img2)
        <div class="content_page__img">
            <x-picture.responsive
                :sizes="['480x320', '768x512', '1200x800']"
                :src="$item->img2"
                :alt="$item->title"
            />
        </div>
    @endif

    @if(!empty($item->video))
        @php $video = $item->video[0] ?? []; @endphp
        @if(!empty($video['url']) || !empty($video['file']))
            <x-media.video
                :src="$video['file'] ?? null"
                :poster="$video['poster'] ?? null"
                :url="$video['url'] ?? null"
            />
        @endif
    @endif

    @if($item->desc2)
        <x-admin.inline-edit :model="$item" field="desc2" label="Описание 2">
            <div class="content_page__desc desc">
                {!! $item->desc2 !!}
            </div>
        </x-admin.inline-edit>
    @endif

    @if(!empty($item->gallery))
        <x-gallery.grid :items="$item->gallery" />
    @endif

    @if($item->html2)
        <x-admin.inline-edit :model="$item" field="html2" label="HTML (низ)">
            <div class="content_page__html">
                {!! $item->html2 !!}
            </div>
        </x-admin.inline-edit>
    @endif

    @if(!empty($item->files))
        <x-files.download :files="$item->files" />
    @endif

    @if($item->custom_field)
        <div class="content_page__custom">
            {!! $item->custom_field !!}
        </div>
    @endif

    @if($item->custom_field2)
        <div class="content_page__custom">
            {!! $item->custom_field2 !!}
        </div>
    @endif

    @if($item->custom_field3)
        <div class="content_page__custom">
            {!! $item->custom_field3 !!}
        </div>
    @endif

    <x-modules.faq :items="$item->faq ?? []" :page-items="$page->faq ?? []" />

</div>

@if($item->script)
    <script>{!! $item->script !!}</script>
@endif
