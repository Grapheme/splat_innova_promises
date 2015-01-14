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
				Новые обещания за {{ $date }}
			</div>
			<div class="normal-text">

				@foreach($users as $user)

					<a href="{{ URL::route('app.profile_id', $user->id) }}" target="_blank">{{ trim($user->name) != '' ? $user->name : $user->identity }}</a>
					{{ $user->city }}
					@if ($user->auth_method != 'native')
						<a href="{{ $user->identity }}" target="_blank">{{ $user->auth_method }}</a>
					@endif
					<br/>

					@foreach ($promises[$user->id] as $promise)

						Обещание №{{ $promise->id }}:<br/>
						{{ $promise->promise_text }}<br/>

					@endforeach

				@endforeach

			</div>
		</div>
	</div>

@stop


@section('scripts')

@stop