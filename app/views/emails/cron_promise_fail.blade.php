<?php
dd(123);
$promise = NULL;
if (isset($promises) && is_object($promises) && NULL !== ($promises = $promises->toArray()) && count($promises) == 1)
    $promise = array_shift($promises);

Helper::tad($promise);
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
        <p>
        @if (is_null($promise))
            Упс... Кажется, вы не успели выполнить своё обещание. Может стоит попробовать ещё раз?
        @else
            Упс... Кажется, вы не успели выполнить своё обещание "<a href="http://mypromises.ru/promise/{{ $promise['id'] }}">{{ $promise['name'] }}</a>". Может стоит попробовать ещё раз?
        @endif
        </p>
		<p>
            <a href="http://mypromises.ru/new_promise">Добавить новое обещание</a>
		</p>
	</div>
</body>
</html>