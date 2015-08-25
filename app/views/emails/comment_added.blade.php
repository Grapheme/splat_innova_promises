<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
			{{ $comment_user->name }} оставил комментарий под вашим обещанием &laquo;{{ $promise->name }}&raquo;:
		</p>
		<p>
			<a href="{{ URL::route('app.promise', $promise->id) }}">Посмотреть комментарий</a>
		</p>
	</div>
</body>
</html>