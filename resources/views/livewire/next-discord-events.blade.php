<div>

    @if($event)
    <div class="container mx-auto max-w-2xl ">
        <h2 class="mb-4 text-2xl tracking-tight leading-tight font-bold">Die nächsten Events</h2>
    </div>

    <aside class="container mx-auto max-w-2xl mb-16 rounded-xl border text-white bg-teal border-teal/20">

        <div class="flex flex-col gap-5 px-4 py-3">
            <div itemscope itemtype="https://schema.org/SocialEvent">
                <h3 itemprop="name" class="font-semibold text-lg ">{{ $event['name'] }}</h3>
                <div class="flex gap-10">
                    <div class="flex gap-1 items-center">
                        <x-icons.calendar class="w-4 h-4" />
                        <time itemprop="startDate" datetime="{{ $event['scheduled_start_time'] }}">
                            {{ \Illuminate\Support\Carbon::parse($event['scheduled_start_time'])->format('d.m.Y') }}
                        </time>
                    </div>
                    @isset($event['entity_metadata']['location'])
                    <div class="flex gap-1 items-center">
                        <x-icons.location class="w-4 h-4" />
                        <span itemprop="location">{{ $event['entity_metadata']['location'] }}</span>
                    </div>
                    @endisset
                </div>

                @isset($event['description'])
                <p itemprop="description">{{ $event['description'] }}</p>
                @endisset
            </div>
        </div>
    </aside>
    @endif
</div>
