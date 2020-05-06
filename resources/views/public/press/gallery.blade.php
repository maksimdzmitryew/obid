@extends('layouts.public')

@section('meta')
    <title>{!! mb_strtoupper($press->title . ' | ' . $festival->name . ' | ' . config('app.name')) !!}</title>
@endsection

@section('content')

<div class="content photo-gallery-page">
    <div class="container-fluid">
        <div class="inner-content">
            <h1 class="block-title">{{ $press->title }}</h1>
            <div class="date-single">{{ $press->created_at->format('d F Y') }}</div>
            <div class="short-single">{{ $press->description }}</div>

            <div class="download-link-wrap">
                @if($press->archive->id)
                    <div class="btn-wrap">
                        <a href="{{ $press->archive->url }}" class="btn grey-btn">
                            <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="15.1579" height="18.0001" fill="black" fill-opacity="0" transform="translate(16) scale(-1 1)"></rect>
                                <rect width="11.2515" height="13.1997" fill="black" fill-opacity="0" transform="translate(14.0469) scale(-1 1)"></rect>
                                <rect width="11.2515" height="13.1997" fill="black" fill-opacity="0" transform="translate(14.0469) scale(-1 1)"></rect>
                                <path d="M2.95294 8.0508L3.78536 7.1508C4.01525 6.9024 4.41315 6.8784 4.67589 7.0956L7.15799 9.162V0.6C7.15799 0.2688 7.44094 0 7.78957 0H9.05273C9.40136 0 9.68431 0.2688 9.68431 0.6V9.162L12.1664 7.0956C12.4279 6.8784 12.8258 6.9024 13.0569 7.1508L13.8894 8.0496C14.1205 8.2992 14.094 8.6796 13.8313 8.898L8.83673 13.0512C8.59799 13.2492 8.24304 13.2492 8.00431 13.0512L3.01104 8.898C2.74831 8.6796 2.72178 8.2992 2.95294 8.0508Z" fill="#0E293C"></path>
                                <rect width="15.1579" height="2.4" fill="black" fill-opacity="0" transform="translate(16 15.6001) scale(-1 1)"></rect>
                                <rect width="15.1579" height="2.4" fill="black" fill-opacity="0" transform="translate(16 15.6001) scale(-1 1)"></rect>
                                <path d="M1.47368 15.6001H15.3684C15.7171 15.6001 16 15.8689 16 16.2001V17.4001C16 17.7313 15.7171 18.0001 15.3684 18.0001H1.47368C1.12505 18.0001 0.842104 17.7313 0.842104 17.4001V16.2001C0.842104 15.8689 1.12505 15.6001 1.47368 15.6001Z" fill="#0E293C"></path>
                            </svg>
                            <span class="text">{{ trans('general.download-all') }} {{ $press->volume }}</span>
                        </a>
                    </div>
                @endif
            </div>

        </div>

        <div class="gallery-block section-line">
            <div class="row">
                @foreach($gallery_parts as $images)
                    <!--div class="col-md-3 col-12 gallery-item"-->
                        @foreach($images as $image)
                            <div class="div_wrap_gallery_img">
                            	<a class="a_wrap_gallery_img" class="d-block gallery-b" data-fancybox="gallery"  href="{!! route('public.image.show', $image->id) !!}/{{ $image->original }}/" data-caption="{{ $image->copyright ? $image->copyright : '' }}">
                                <img class="img-fluid" src="{!! route('public.image.show', $image->id) !!}/{{ $image->original }}/small" alt="{{ $image->copyright ? $image->copyright : '' }}">
                            	</a>
                            	<span class="copyright">
                            		{{ $image->copyright ? $image->copyright : '' }}
                            	</span>
                        	</div>
                        @endforeach
                    <!--/div-->
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection