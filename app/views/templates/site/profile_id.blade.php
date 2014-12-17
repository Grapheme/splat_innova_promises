@extends(Helper::layout())

@section('style')
@stop


@section('koe-chto')
    <li class="promise-item type-promo">
        <div class="promise-content">
            <div class="logo"></div>
            <div class="text">
                <p>Каждый раз, выполняя обещания,<br> вы становитесь чуточку лучше.</p>
                <p>Мы тоже хотим вам пообещать<br><a href="#" class="js-open-box" data-box="promo">кое-что</a></p>
            </div>
        </div>
    </li>
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

            <div class="wrapper">
              <div class="us-text">Этот пользователь уже зарегистрирован на сайте, но пока не давал обещаний.</div>
            </div>

        @endif

    @endif


    <?
    $default_avatar = '/theme/images/man.png';
    if (isset($user->sex) && $user->sex == 1)
        $default_avatar = '/theme/images/woman.png';
    ?>

      <div class="profile-page">
        <div class="wrapper">
          <div class="profile-card">
            <div style="background-image: url({{ $user->avatar ?: $default_avatar }});" class="profile-photo"></div>
            <div class="profile-info">
              <div class="info-cont">
                <div class="name"><span>{{ $user->name }}</span></div>
              </div>
                @if ($user->years_old)
                    <div class="age">
                        {{ trans_choice(':count год|:count года|:count лет', $user->years_old, array(), 'ru') }}
                    </div>
                @endif
            </div>
          </div>
          <div class="promises-title us-title">Обещания</div>
        </div>


        @if (isset($promises) && is_object($promises) && count($promises))

            <?
            $p = 0;
            ?>
            <ul class="promises-list">
            @foreach ($promises as $promise)
            <?
            ++$p;
            if (!$promise->style_id) {
                $styles = array('green', 'aqua', 'yellow', 'blue', 'pink');
                $promise->style_id = $styles[array_rand($styles)];
            }
            ?>
              <li class="promise-item type-{{ $promise->style_id }}" data-finish="{{ $promise->time_limit }}">
                <a href="{{ URL::route('app.promise', $promise->id) }}" class="promise-content">
                  <div class="title">
                    {{ $promise->name }}
                  </div>
                  <div class="bottom-block">
                    <div class="top-floor">
                        @if ($promise->only_for_me)
                            <div class="eye eye-cross" data-tooltip="Обещание защищено настройками приватности<br>и видимо только вам."></div>
                        @else
                            <div class="eye" data-tooltip="Обещание видно всем пользователям."></div>
                        @endif
                      <!-- <div class="eye{{ ( $promise->only_for_me ? ' eye-cross' : '') }}"></div> -->
                    </div>
                    <div class="bottom-floor">
                      <!--
                      <div class="views">15</div>
                      -->
                      <div class="comments" data-tooltip="{{ trans_choice(':count комментарий|:count комментария|:count комментариев', (int)$promise->comments_count, array(), 'ru') }} к этому обещанию.">{{ $promise->comments_count }}</div>

                        <?
                        $failed = !$promise->finished_at && ($promise->promise_fail || date('Y-m-d H:i:s') > $promise->time_limit);
                        ?>
                        @if ($failed)
                            <div class="unsmile" data-tooltip="Обещание не было выполнено.">
                                <!-- <i class="fi icon-no"></i> -->
                            </div>
                        @elseif ($promise->finished_at)
                            <div class="smile" data-tooltip="Обещание выполнено.">
                                <!-- <i class="fi icon-okey"></i> -->
                            </div>
                        @else
                            <!-- <div class="time">02:01:23</div> -->
                        @endif

                    </div>
                  </div>
                </a>
              </li>

                @if (@$p == 2)
                    @yield('koe-chto')
                @endif

            @endforeach

            @if (@$p == 1)
                @yield('koe-chto')
            @endif

            </ul>
        @else

            <div class="wrapper">
              <div class="us-text">Этот пользователь уже зарегистрирован на сайте, но пока не давал обещаний.</div>
            </div>
            
        @endif

@stop


@section('scripts')

@stop