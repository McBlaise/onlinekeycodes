@foreach($users as $ls)
	<p>{{ $ls->id }}</p>
	@foreach($ls->files as $file)
		<img src="/storage/files/{{ $file->filename.'.'.$file->extension }}">
		<a href="/download/{{ $file->filename.'.'.$file->extension }}"></a>
	@endforeach

@endforeach