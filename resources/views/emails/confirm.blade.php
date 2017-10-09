<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>sign up confirm link</title>
</head>
<body>
	<h1>Appciate your registed!</h1>

	<p>
		please click under link to compeled your registed:
		<a href="{{ route('confirm_email',$user->activation_token) }}">
			{{ route('confirm_email', $user->activation_token) }}
		</a>
	</p>

	<p>
		If not your rase up,please ignor this email.
	</p>
</body>
</html>
