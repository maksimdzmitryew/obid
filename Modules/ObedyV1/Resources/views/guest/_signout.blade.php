					<form action="{!! route('signout_user') !!}" method="POST">
						@csrf
						<button class="{!! $class !!}">
							<i class="icon-switch2"></i>
							{!! trans('user/form.button.signout') !!}
						</button>
					</form>
