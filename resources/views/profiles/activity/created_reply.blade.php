<div class="panel panel-default">
	<div class="panel-heading">
		<div class="level">
			{{ $profileUser->name }} replied to&nbsp; <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>
			{{-- <span class="flex"><a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted: 
				<a href="{{ $thread->path() }}">{{ $thread->title }}</a></span>
			<span>{{ $thread->created_at->diffForHumans() }}</span> --}}
		</div>
	</div>
	<div class="panel-body">
		<p>{{ $activity->subject->body }}</p>
	</div>
</div>
