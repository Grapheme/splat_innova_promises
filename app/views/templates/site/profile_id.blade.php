@extends(Helper::layout())


@section('style')
@stop


@section('content')

    @if (0)

        <big><a href="{{ $user->identity }}" target="_blank">{{ $user->name }}</a></big>

        <br/>

        Обещаний: {{ @count($promises) }}<br/>

        @if (isset($promises) && is_object($promises) && count($promises))

            Обещания пользователя:

            {{ Helper::ta($promises) }}

            <ul>
            @foreach ($promises as $promise)
                {{ Helper::ta_($promise) }}
                <?
                if ($promise->only_for_me)
                    continue;
                ?>
                <li><a href="{{ URL::route('app.promise', $promise->id) }}">{{ $promise->name }}</a></li>
            @endforeach
            </ul>
        @else

            Пользователь еще не давал обещаний.

        @endif

    @endif


      <div class="profile-page">
        <div class="wrapper">
          <div class="profile-card">
            <div style="background-image: url({{ $user->avatar }});" class="profile-photo"></div>
            <div class="profile-info">
              <div class="info-cont">
                <div class="name"><span>{{ $user->name }}</span></div>
              </div>
            </div>
          </div>
          <div class="promises-title us-title">Обещания</div>
        </div>


        @if (isset($promises) && is_object($promises) && count($promises))

            <ul class="promises-list">
            @foreach ($promises as $promise)
            <?
            if (!$promise->style_id) {
                $styles = array('green', 'aqua', 'yellow', 'blue', 'pink');
                $promise->style_id = $styles[array_rand($styles)];
            }
            ?>
              <li class="promise-item type-{{ $promise->style_id }}" data-finish="{{ $promise->date_finish }}">
                <div class="promise-content">
                  <div class="title">
                    <a href="{{ URL::route('app.promise', $promise->id) }}">
                        {{ $promise->name }}
                    </a>
                  </div>
                  <div class="bottom-block">
                    <div class="top-floor">
                      <div class="eye{{ ( $promise->only_for_me ? ' eye-cross' : '') }}"></div>
                    </div>
                    <div class="bottom-floor">
                      <!--
                      <div class="views">15</div>
                      -->
                      <div class="comments">{{ $promise->comments_count }}</div>
                      <div class="time">02:01:23</div>
                    </div>
                  </div>
                </div>
              </li>

            @endforeach
            </ul>
        @else

            Пользователь еще не давал обещаний.

        @endif

@stop


@section('scripts')

@stop