@include('user._list_actions')
@include('user._list_checkbox', ['s_name' => 'published', ])


@if (!isset($b_title) || (isset($b_title) && $b_title))
@include('user._list_text', ['s_name' => 'title', ])
@endif

@if (isset($a_columns) && count($a_columns) > 0)
@foreach ($a_columns AS $s_name => $s_type)
@include('user._list_' . $s_type, ['s_name' => $s_name, ])
@endforeach
@endif

@include('user._list_date', ['s_name' => 'created_at', ])
@include('user._list_date', ['s_name' => 'updated_at', ])
@include('user._list_id')
