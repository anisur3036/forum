@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $thread->title }} <span class="pull-right">{{ $thread->creator->name }}</span></div>

                <div class="panel-body">
                	<p>{{ $thread->body }}</p>
                </div>
            </div> 
            @foreach ($replies as $reply)
                @include ('threads.reply')
            @endforeach

            {{ $replies->links() }}

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
                    {{ $thread->replies_count ?: 'no' }} 
                    {{ str_plural('comment', $thread->replies_count) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
