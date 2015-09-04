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
                У вас осталось совсем немного времени для выполнения обещания. Поторопитесь!
            @else
                Осталось совсем немного времени для выполнения вашего обещания "<a href="http://mypromises.ru/promise/{{ $promise['id'] }}">{{ $promise['name'] }}</a>". Поторопитесь!
            @endif
		</p>
		<p>
			Посмотреть все свои обещания вы можете в <a href="http://mypromises.ru/me">профиле</a>
		</p>
	</div>
</body>
</html>