@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="level">
                    <div class="panel-heading flex">{{ $thread->title }} <span><a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a></span></div>
                        @can ('update', $thread)
                            <form action="{{ $thread->path() }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-link">Delete thread</button>
                            </form>
                        @endcan
                    </div>

                    <div class="panel-body">
                    	<p>{{ $thread->body }}</p>
                    </div>
                </div>
                <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>
                {{-- {{ $replies->links() }} --}}

                @if (Auth()->check())
                    <form action="{{ $thread->path() }}/replies" method="POST" role="form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Reply</button>
                    </form>
                @else
                 <p class="text-center">Please <a href="/login">sign in</a> to reply</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                       <p>This thread was published {{  $thread->created_at->diffForHumans() }} 
                        by <a href="{{ route('profile', $thread->creator ) }}">{{ $thread->creator->name }}</a>, and currently has 
                        <span v-text="repliesCount"></span>
                        {{ str_plural('comment', $thread->replies_count) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
