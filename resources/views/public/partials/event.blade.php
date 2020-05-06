<div class="event-item"
     data-id="{!! $event->id !!}"
     data-title="{!! $event->title !!}"
     data-description="{!! $event->description !!}"
>
    <div class="row d-flex align-items-center">
        <div class="col-lg-4 col-12">
            <div class="img-wrap">
                {{--@auth--}}
                    @if($event->isFavorited())
                        <div class="bookmark added" data-event-id="{!! $event->id !!}">
                            <svg class="mark_icon" width="25" height="37" viewBox="0 0 25 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 0V34.2246C1 35.0039 1.85185 35.4837 2.51829 35.0799L12.0077 29.3289C12.339 29.1281 12.7563 29.1367 13.079 29.3509L21.5433 34.9692C22.208 35.4104 23.0963 34.9338 23.0963 34.136V0" stroke="white" stroke-width="2"/>
                            </svg>
                            <span class="mark-plus">+</span>
                        </div>
                    @else
                        <div class="bookmark" data-event-id="{!! $event->id !!}">
                            <svg class="mark_icon" width="25" height="37" viewBox="0 0 25 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 0V34.2246C1 35.0039 1.85185 35.4837 2.51829 35.0799L12.0077 29.3289C12.339 29.1281 12.7563 29.1367 13.079 29.3509L21.5433 34.9692C22.208 35.4104 23.0963 34.9338 23.0963 34.136V0" stroke="white" stroke-width="2"></path>
                            </svg>
                            <span class="mark-plus">+</span>
                        </div>
                    @endif
                {{--@endauth--}}
                <a href="{{-- route('public.festival.event', [$festival->slug, $event->slug]) --}}"><img src="{{ $event->image->small_image_url ? $event->image->small_image_url : '/admin/images/no-image-logo.jpg'}}" alt="{{ $event->image->name ? $event->image->name : 'no image'}}"></a>
            </div>
        </div>
        <div class="col-lg-8 col-12">
            <div class="descr">
                <h5 class="event-title"><a href="{{-- route('public.festival.event', [$festival->slug, $event->slug]) --}}">{{ $event->title }}</a></h5>
                <div class="short small-text">{!! $event->description !!}</div>
                <div class="box">
                    <a class="label">{{ $event->category->name }}</a>
                    <div class="name">{{ $event->directors->map->name->implode(', ') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="sub-event sub-event-stoke">
        <div class="row flex-nowrap item-wrap">
            @foreach($event->holdings as $holding)
                <div class="sub-event-item col-lg-3 col-sm-4 col-6 holding"
                     data-id="{!! $holding->id !!}"
                     data-date-from="{!! $holding->date_from !!}"
                     data-date-to="{!! $holding->date_to !!}"
                     data-city="{!! $holding->city->name !!}"
                     data-timezone="{!! $holding->city->timezone !!}"
                     data-place="{!! $holding->place->name !!}"
                >
                    <div class="info-box"><a href="{{-- route('public.festival.event', [$festival->slug, $event->slug]) --}}">
						@include('public.partials.date_format', ['from' => $holding->date_from, 'to' => $holding->date_to])
                        <div class="name">{{ $holding->city->name }}, {{ $holding->place->name }}</div></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>