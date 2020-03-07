@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="page-header">
				  <h1>{{ $profileUser->name }}</div>
					@foreach($activities as $date => $activity)
						<h3 class="page-header">{{ $date }}</h3>
						@foreach($activity as $record)
							@if (view()->exists("profiles/activity/{$record->type}"))
								@include ("profiles/activity/{$record->type}", ['activity' => $record])
							@endif
						@endforeach
					@endforeach
					{{-- {{ $threads->links() }} --}}
				</div>
			</div>
	</div>
@endsection
