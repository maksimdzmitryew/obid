<div class="col-lg-9 col-md-8 col-12 single-content">
    <div class="tab-content inner-tab-content" id="v-board-tabContent">

    @foreach($items as $item)
        <div class="tab-pane fade {{ $loop->iteration == 1 ? 'show active' : '' }}"
            id="v-pills-{{ $s_type }}-{{ $loop->iteration }}"
            role="tabpanel"
            aria-labelledby="v-pills-{{ $s_type }}-tab-{{ $loop->iteration }}"
        >
            <div class="inner">
                <div class="row">
                    <div class="photo-wrap col-lg-4 col-12">
                        <img src="{{ $item->image->url }}" alt="">
                    </div>
                    <div class="about-descr col-lg-8 col-12">
                        <div class="name">{{ $item->name }}</div>
                        <div class="post">{{ $item->profession }}</div>
                        <div class="btns-wrap d-flex four-btns">
                            @include('public.partials.btn_email')
                            @include('public.partials.btn_facebook')
                        </div>
                        <div class="text">
                            {!! $item->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    </div>
</div>
