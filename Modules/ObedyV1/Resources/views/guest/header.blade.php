<header>
	<div class="container fullwidth">
		<div class="flexwrap">
			<a href="/" class="logo">
				<img src="/{!! $theme !!}/img/logo.png" alt="">
			</a>
			@include($theme . '::' . $_env->s_utype . '._header_menu')
		</div>
	</div>
</header>
