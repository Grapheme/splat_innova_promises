<?php
$promise = NULL;
if (isset($promises) && is_object($promises) && NULL !== ($promises = $promises->toArray()) && count($promises) == 1)
    $promise = array_shift($promises);
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
                Время выполнения вашего обещания истекло, но вы не изменили его статус. Возможно, вы еще не успели этого сделать.
            @else
                Время выполнения вашего обещания "<a href="http://mypromises.ru/promise/{{ $promise['id'] }}">{{ $promise['name'] }}</a>" истекло, но вы не изменили его статус. Возможно, вы еще не успели этого сделать.
            @endif
		</p>
		<p>
			Пожалуйста, не забудьте обновить <a href="http://mypromises.ru/me">статус выполнения</a>, или через 48 часов ваше обещание будет переведено в невыполненные.
		</p>
	</div>
</body>
</html>