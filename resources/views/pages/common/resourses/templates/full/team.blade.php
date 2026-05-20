<section class="team-wrap team-leader">
    @if($item->img)
        <div class="team-leader__photo">
            <x-picture.responsive
                :sizes="['480x420', '500x495']"
                :src="$item->img"
                :alt="$item->title"
                class="team-leader__photo-img"
            />
        </div>
    @endif

    <div class="team-leader__card">
        @if($item->subtitle)
            <span class="team-leader__role">{{ $item->subtitle }}</span>
        @endif

        <h2>{{ $item->title }}</h2>

        @if($item->short_desc)
            <p>{!! $item->short_desc !!}</p>
        @endif

        @if(!empty($item->card_items))
            <div class="team-leader__meta">
                @foreach($item->card_items as $meta)
                    <div>
                        <strong>{{ $meta['title'] }}</strong>
                        <span>{{ $meta['desc'] }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</section>
