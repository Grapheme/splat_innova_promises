@extends(Helper::layout())


@section('style')
@stop


@section('content')

	<div class="wrapper">
		<div class="normal-wrapper">
			<div class="normal-title">
				Статистика
			</div>
			<div class="normal-text">
				<p>
					Пользователей за все время - {{ $total_users }}, обещаний за все время - {{ $total_promises }}.
				</p>



				@if (@count($users) && 0)
					<table border="1">
					@foreach($users as $user)
						<tr>
							<td>
								{{ $user->day }}
							</td>
							<td>
								{{ $user->count }}
							</td>
						</tr>
					@endforeach
					</table>
				@endif

			</div>
		</div>
	</div>

@stop


@section('scripts')

@stop