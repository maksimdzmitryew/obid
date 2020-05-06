@if ($from->format('d_m_y') == $to->format('d_m_y'))
<div class="time">
	{{
		$from->format('H:i')
	}}@if (
		$from->format('H_i') != $to->format('H_i')
		)&nbsp;&mdash;&nbsp;{{ $to->format('H:i')
	}}@endif {{ trans('general.time-after') }}
</div>
@endif
<div class="date">
    {{
        $from->format('d')
            . trans('general.date-split')
            . $from->format('m')
            . trans('general.date-after')
    }}@if (
    $from->format('d_m_y') != $to->format('d_m_y')
    )&nbsp;&mdash;&nbsp;{{
        $to->format('d')
            . trans('general.date-split')
            . $to->format('m')
            . trans('general.date-after')
    }}
    @endif
</div>