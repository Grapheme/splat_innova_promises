<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
            Вы только что оставили обещание &laquo;{{ $promise->name }}&raquo; на <a href="http://mypromises.ru/promise/{{ $promise->id }}">mypromises.ru</a>, и сделали первый шаг к своей цели. Мы в вас верим!
		</p>
		<p>
			<img src="{{ $message->embed($img_path) }}">
		</p>
	</div>
</body>
</html>