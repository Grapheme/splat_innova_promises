<?php

    function getNumEnding($number, $endingArray)
    {
        $number = $number % 100;
        if ($number>=11 && $number<=19) {
            $ending=$endingArray[2];
        }
        else {
            $i = $number % 10;
            switch ($i)
            {
                case (1): $ending = $endingArray[0]; break;
                case (2):
                case (3):
                case (4): $ending = $endingArray[1]; break;
                default: $ending=$endingArray[2];
            }
        }
        return $ending;
    }

?>

<li class="promise-item type-{{ $promise->style_id }}" @if(@promise_type == 'active') data-finish="{{ $promise->time_limit }}" @endif>
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
                <div class="comments" data-tooltip="{{ (int)$promise->comments_count }} {{getNumEnding((int)$promise->comments_count, array('комментарий, комментария, комментариев'))}} к этой записи">{{ (int)$promise->comments_count }}</div>

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
