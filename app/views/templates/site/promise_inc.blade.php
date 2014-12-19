<li class="promise-item type-{{ $promise->style_id }}" @if(@promise_type == 'active') data-finish="{{ $promise->time_limit }}" @endif>
    <a href="{{ URL::route('app.promise', $promise->id) }}" class="promise-content">
        <div class="title">
            {{ $promise->name }}
            <br/>
            prom: {{ $promise->time_limit }}<br/>
            date: {{ date('Y-m-d H:i:s') }}<br/>
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

                <div class="comments" data-tooltip="{{ trans_choice(':count комментарий|:count комментария|:count комментариев', (int)$promise->comments_count, array(), 'ru') }} к этому обещанию.">{{ (int)$promise->comments_count }}</div>

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
