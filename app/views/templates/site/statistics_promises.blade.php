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

					<ul>
					@foreach ($promises[$user->id] as $promise)

						<li>
							<a href="{{ URL::route('app.promise', ['id' => $promise->id]) }}" target="_blank">{{ $promise->id }}</a>:
							{{ $promise->promise_text }}
							@if ($promise->only_for_me)
								<i class="fa fa-lock"></i>
							@endif
						</li>

					@endforeach
					</ul>

				@endforeach

			</div>
		</div>
	</div>

@stop


@section('scripts')

@stop