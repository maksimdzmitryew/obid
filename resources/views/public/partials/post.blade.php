<div class="col-lg-3 col-sm-6 col-12">
    <div class="news-item">
        <div class="img-wrap">
            <div class="label">{{ $post->category->name }}</div>
            <a href="{{-- route('public.festival.post', [$festival->slug, $post->slug]) --}}"><img src="{{ $post->image->small_image_url ? $post->image->small_image_url : '/admin/images/no-image-logo.jpg'}}" alt=""></a>
        </div>
        <div class="descr">
            <div class="date">{{ $post->published_at_day }}</div>
            <h4 class="news-title"><a href="{{-- route('public.festival.post', [$festival->slug, $post->slug]) --}}">{{ $post->title }}</a></h4>
            <div class="short">
                {{ $post->excerpt }}
            </div>
        </div>
    </div>
</div>