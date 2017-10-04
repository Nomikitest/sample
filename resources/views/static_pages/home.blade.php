@extends('layouts.default')
@section('content')
	<div class="jumbotron">
		<h1>Hello Laravel!</h1>
		<p class="lead">
			Now you can see it <a herf="https://fsdhub.com/boos/laravel-essential-training-5.5">Laravel introduction</a> main page.
		</p>
		<p>
			It's starting in this way.
		</p>
		<p>
			<a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">inmediatelly register!</a>
		</p>
	</div>
@stop
