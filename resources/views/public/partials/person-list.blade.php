<aside class="right-sidebar col-lg-3 col-md-4 col-12">
    <div class="sidebar-inner">
        <div class="nav flex-column nav-pills" id="v-{{ $s_type }}-tab" role="tablist" aria-orientation="vertical">
            @foreach($items as $item)
                <a class="nav-link {{ $loop->iteration == 1 ? 'active' : '' }}"
                    id="v-pills-{{ $s_type }}-tab-{{ $loop->iteration }}" data-toggle="pill"
                    href="#v-pills-{{ $s_type }}-{{ $loop->iteration }}" role="tab" 
                    aria-controls="v-pills-{{ $s_type }}-{{ $loop->iteration }}"
                    aria-selected="true"
                >
                    <div class="name">{{ $item->name }}</div>
                    <div class="post">{{ $item->profession }}</div>
                </a>
            @endforeach
        </div>
    </div>
</aside>
