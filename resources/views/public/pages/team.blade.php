<div class="single-event-wrap single-fest-wrap">
    <div class="row">

        @include('public.partials.person-item', ['items' => $team_members, 's_type' => 'team'])
        @include('public.partials.person-list', ['items' => $team_members, 's_type' => 'team'])

    </div>
</div>