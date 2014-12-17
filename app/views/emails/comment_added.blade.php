<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
			Михаил Потапов оставил комментарий под вашим обещанием:
		</p>
		<p>
			<a href="{{ URL::route('app.promise', $promise->id) }}">Открыть комментарий</a>
		</p>
	</div>
</body>
</html>