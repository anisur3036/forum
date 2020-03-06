@component('profiles.activity.activity')
	@slot('heading')
		{{ $profileUser->name }} replied to&nbsp; 
		<a href="{{ $activity->subject->thread->path() }}">
			{{ $activity->subject->thread->title }}
		</a>
	@endslot

	@slot('body')
		{{ $activity->subject->body }}
	@endslot
@endcomponent
