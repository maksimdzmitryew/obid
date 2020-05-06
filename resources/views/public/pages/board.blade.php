<div class="single-event-wrap single-fest-wrap">
    <div class="row">

        @include('public.partials.person-item', ['items' => $board_members, 's_type' => 'board'])
        @include('public.partials.person-list', ['items' => $board_members, 's_type' => 'board'])

    </div>
</div>