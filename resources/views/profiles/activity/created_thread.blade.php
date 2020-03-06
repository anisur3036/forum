@component('profiles.activity.activity')
	@slot('heading')
		{{ $profileUser->name }} published&nbsp;
		<a href="{{ $activity->subject->path() }}">
			{{ $activity->subject->title }}
		</a>
	@endslot
	@slot('body')
		{{ $activity->subject->body }}
	@endslot
@endcomponent