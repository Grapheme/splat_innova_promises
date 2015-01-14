@extends(Helper::layout())


@section('style')
	<style>
		.stat-table td {
			padding: 5px 8px;
		}
	</style>
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

				<p>

					{{ Form::text('date_start', null, ['placeholder' => 'yyyy-mm-dd']) }}
					{{ Form::text('date_stop', null, ['placeholder' => 'yyyy-mm-dd']) }}

				</p>

				<table border="1" class="stat-table">
				@foreach($days as $day)
					<?
					$users_count = isset($users[$day]) && is_object($users[$day]) ? $users[$day]->count : 0;
					$promises_count = isset($promises[$day]) && is_object($promises[$day]) ? $promises[$day]->count : 0;
					?>
					<tr>
						<td>
							{{ $day }}
						</td>
						<td>
							{{ trans_choice(':count новый пользователь|:count новых пользователя|:count новых пользователей', $users_count, array(), 'ru') }}
						</td>
						<td>
							<a href="{{ URL::route('app.statistics_promises', ['date' => $day]) }}">
								{{ trans_choice(':count новое обещание|:count новых обещания|:count новых обещаний', $promises_count, array(), 'ru') }}
							</a>
						</td>
					</tr>
					@if (isset($users[$day]) && is_object($users[$day]) && $users[$day]->count > 0)
						<tr>
							<td colspan="3">
								@foreach ($users_full as $u => $user)
									@if ($user->day == $day)
										<?
											unset($users_full[$u]);
										?>
											<a href="{{ URL::route('app.profile_id', $user->id) }}" target="_blank">{{ trim($user->name) != '' ? $user->name : $user->identity }}</a>
											{{ $user->city }}
											@if ($user->auth_method != 'native')
												<a href="{{ $user->identity }}" target="_blank">{{ $user->auth_method }}</a>
											@endif
											<br/>
									@endif
								@endforeach
							</td>
						</tr>
					@endif
				@endforeach
				</table>

			</div>
		</div>
	</div>

@stop


@section('scripts')

@stop