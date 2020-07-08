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
@include($theme . '::layouts._social_networks')
@include($theme . '::layouts._lang')
			<div class="contact_us">
				<p>Contact&nbsp;us&nbsp;<a target="_blank" href="mailto:obed@efte.in">obed@efte.in</a></p>
			</div>
		</div>
		{{-- <button class="open_filter_btn">Показать фильтр</button> --}}
		<div class="divider"></div>
	</div>
</footer>
