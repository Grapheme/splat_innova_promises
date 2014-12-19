<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
			У вас осталось менее 2 дней для выполнения обещания. Поторопитесь!
		</p>
		<p>
			<a href="{{ URL::route('app.profile_id', $user->id) }}">Посмотреть свои обещания</a>
		</p>
	</div>
</body>
</html>