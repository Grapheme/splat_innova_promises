<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
            Здравствуйте, {{ $name }}!
		</p>
		<p>
            Ваш друг, {{ $user->name }}, выслал Вам приглашение в проект Мои Обещания.
		<p>
		</p>
            <a href="http://{{ $_SERVER['HTTP_HOST'] }}">Присоединиться</a>
		</p>
	</div>
</body>
</html>