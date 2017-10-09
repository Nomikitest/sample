<form action="{{ route('statuses.store') }}" method="POST">
	@include('shared._errors')
	{{ csrf_field() }}
	<textarea class="form-control" rows="3" placeholder="dajsfjasifi" name="content">{{ old('content') }}</textarea>
	<button type="submit" class="btn btn-primary pull-right">push up</button>
</form>
