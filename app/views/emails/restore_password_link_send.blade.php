<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
            Для сброса пароля перейдите по ссылке: {{ URL::route('app.restore_password_open_link', array('token' => $token)) }}
		</p>
	</div>
</body>
</html>