<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
            Привет! Твой друг {{ $user->name }} оставил тебе <a href="http://mypromises.ru/promise/{{ $promise->id }}">персональное обещание</a>.
        </p>
        <p>
            Кстати, ты тоже можешь дать своё обещание на сайте <a href="http://mypromises.ru/">mypromises.ru</a>.
        </p>
	</div>
</body>
</html>