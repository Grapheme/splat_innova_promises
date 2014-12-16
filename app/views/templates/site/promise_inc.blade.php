<li class="promise-item type-{{ $promise->style_id }}" @if(@promise_type == 'active') data-finish="{{ $promise->time_limit }}" @endif>
    <a href="{{ URL::route('app.promise', $promise->id) }}" class="promise-content">
        <div class="title">
            {{ $promise->name }}
        </div>
        <div class="bottom-block">
            <div class="top-floor">
                @if ($promise->only_for_me)
                    <div class="eye eye-cross" data-tooltip="Обещание защищено настройками приватности и видимо только вам."></div>
                @else
                    <div class="eye"></div>
                    @endif
                            <!-- <div class="eye{{ ( $promise->only_for_me ? ' eye-cross' : '') }}"></div> -->
            </div>
            <div class="bottom-floor">
                <!--
                <div class="views">15</div>
                -->
                <div class="comments" data-tooltip="{{ (int)$promise->comments_count }} человека оставили свои комментарии">{{ (int)$promise->comments_count }}</div>

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
