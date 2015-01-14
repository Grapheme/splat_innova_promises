@extends(Helper::layout())


@section('style')
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
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

					<form action="?" method="GET">
						{{ Form::text('date_start', $start->format('Y-m-d'), ['placeholder' => 'yyyy-mm-dd']) }}
						{{ Form::text('date_stop', $stop->format('Y-m-d'), ['placeholder' => 'yyyy-mm-dd']) }}
						<button>Отправить</button>
					</form>

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

				<h2>Истекающие обещания</h2>

				@if ($expired_promises && count($expired_promises))
					<ul>
						@foreach($expired_promises as $promise)

							<li>
								<a href="{{ URL::route('app.promise', ['id' => $promise->id, 'private' => md5(date('Y-m-d') . '_' . $promise->id)]) }}" target="_blank">{{ $promise->id }}</a>
								@if (isset($expired_promises_users[$promise->user_id]) && $expired_promises_users[$promise->user_id]->auth_method != 'native')
									<a href="{{ $expired_promises_users[$promise->user_id]->identity }}">
										<i class="fa fa-user"></i>
									</a>
								@endif
								{{ $promise->time_limit }}
								{{ $promise->promise_text }}
								@if ($promise->only_for_me)
									<i class="fa fa-lock"></i>
								@endif
							</li>

						@endforeach
					</ul>
				@else
					Ничего не найдено.
				@endif

			</div>
		</div>
	</div>

@stop


@section('scripts')

@stop