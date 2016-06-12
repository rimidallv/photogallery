@extends('layouts.blog-post')


@section('content')
    <h1>Post</h1>

    <!-- Blog Post -->

    <!-- Title -->
    <h1>{{$post->title}}</h1>

    <!-- Author -->
    <p class="lead">
        by <a href="#">{{$post->user->name}}</a>
    </p>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted on {{$post->created_at}}</p>

    <hr>

    <!-- Preview Image -->
    <img class="img-responsive" src="{{$post->photo->file}}" alt="">

    <hr>
    @if(Session::has('comment_message'))
    {{session('comment_message')}}
    @endif

            <!-- Post Content -->
    <p class="lead"> {{$post->body}}</p>

    <hr>

    <!-- Blog Comments -->
    @if(Auth::check())
            <!-- Comments Form -->
    <div class="well">
        <h4>Leave a Comment:</h4>

        {!! Form::open(['method'=>'POST', 'action'=>'PostCommentsController@store']) !!}

        <input type="hidden" name="post_id" value="{{$post->id}}">
        <div class="form-group">
            {!! Form::label('body', 'Body') !!}
            {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>1]) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Add comment',  ['class'=>'btn btn-primary ']) !!}
        </div>

        {!! Form::close() !!}
    </div>
    @endif
    <hr>

    <!-- Posted Comments -->
    @if(count($comments)>0)
            <!-- Comment -->
    @foreach($comments as $comment)
        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object" src="{{$comment->photo}}" height="64" alt="">
            </a>
            <div class="media-body">
                <h4 class="media-heading">{{$comment->author}}
                    <small>{{$comment->created_at}}</small>
                </h4>
                <p>{{$comment->body}}</p>

                @if(count($comment->replies)>0)
                    @foreach($comment->replies as $reply)
                        @if($reply->is_active==1)
                <div  id ="nested-comment" class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object"  height="64" src="{{$reply->photo}}" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <small></small>
                        </h4>
                        <p>{{$reply->body}}</p>
                    </div>
                    {!! Form::open(['method'=>'POST', 'action'=>'CommentRepliesController@createReply']) !!}
                    <input type="hidden" name="comment_id" value="{{$comment->id}}" />
                    <div class="form-group">
                        {!! Form::label('body', 'Body') !!}
                        {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>3]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Add reply',  ['class'=>'btn btn-primary ']) !!}
                    </div>

                    {!! Form::close() !!}


                </div>

            </div>
            @endif
            @endforeach
            @else
                <div  id ="nested-comment" class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object"  height="64" src="" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <small></small>
                        </h4>
                        <p></p>
                    </div>
                    {!! Form::open(['method'=>'POST', 'action'=>'CommentRepliesController@createReply']) !!}
                    <input type="hidden" name="comment_id" value="{{$comment->id}}" />
                    <div class="form-group">
                        {!! Form::label('body', 'Body') !!}
                        {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>3]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Add reply',  ['class'=>'btn btn-primary ']) !!}
                    </div>
            @endif
        </div>

        @endforeach
        @endif
                <!-- Comment -->


        </div>
        </div>

@stop