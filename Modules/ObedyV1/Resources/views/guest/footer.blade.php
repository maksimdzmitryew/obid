<footer>
	<div class="container fullwidth">
		<div class="flexwrap">
			<div class="copyright">
				<p>
					{!! $settings->title !!} &copy;
				</p>
				<p>
					@if ($settings->established != date("Y")) {!! $settings->established !!} &mdash; @endif
					{!! @date("Y") !!}
				</p>
			</div>
			<div class="credits">
				@if(isset($texts->credits))
				<p>
				{!! trans($texts->credits, ['app_name' => $_env->s_title]) !!}
				</p>
				@endif

@include($theme . '::' . $_env->s_utype . '._confidentiality_info', ['id' => 'footer'])

			</div>
@include($theme . '::layouts._social_networks')
@include($theme . '::layouts._lang')
			<div class="contact_us">
				<p>Contact&nbsp;us&nbsp;<a target="_blank" href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></p>
			</div>
		</div>
		{{-- <button class="open_filter_btn">Показать фильтр</button> --}}
		<div class="divider"></div>
	</div>
</footer>
