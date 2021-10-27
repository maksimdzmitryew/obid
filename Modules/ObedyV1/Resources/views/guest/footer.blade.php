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
				<p>
				<a href="https://europa.eu/" target="_blank">
					<img width="67" height="60" src="/images/europa-flag.gif" />
					This website was created and maintained with the financial support of the European Union. Its contents are the sole responsibility of the <strong>Debate for Changes NGO</strong> and do not necessarily reflect the views of the European Union
				</a>
				</p>

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
