@extends(Helper::layout())


@section('style')
@stop


@section('content')


    {{ Form::model(NULL, array('url' => URL::route('app.add_promise'), 'class' => 'smart-form', 'id' => 'promise-form', 'role' => 'form', 'method' => 'PUT', 'files' => true)) }}

        Я обещаю, что...<br/>

        {{ Form::textarea('promise_text', @$_SESSION['promise_text']) }}<br/>

        Срок: {{ Form::text('time_limit', 14) }} дней<br/>
        <label>
            {{ Form::checkbox('only_for_me') }} видно только мне
        </label>

        <br/>

        {{ Form::submit('Добавить') }}

    {{ Form::close() }}

@stop


@section('scripts')
@stop