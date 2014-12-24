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
					@if (isset($users[$day]) && is_object($users[$day]) && $users[$day]->count > 0)
						<tr>
							<td colspan="2">
								@foreach ($users_full as $u => $user)
									@if ($user->day == $day)
										<?
											unset($users_full[$u]);
										?>
										<a href="{{ URL::route('app.profile_id', $user->id) }}" target="_blank">{{ $user->name != '' ? $user->name : $user->identity }}</a><br/>
									@endif
								@endforeach
							</td>
						</tr>
					@endif
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