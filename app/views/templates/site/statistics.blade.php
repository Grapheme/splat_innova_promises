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

				<table border="1">
				@foreach($days as $day)
						<tr>
							<td>
								{{ $day }}
							</td>
							<td>
								{{ isset($users[$day]) && is_object($users[$day]) ? $users[$day]->count : '0' }}
							</td>
						</tr>
				@endforeach
				</table>


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