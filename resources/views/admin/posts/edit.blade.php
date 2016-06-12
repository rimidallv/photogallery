@extends('layouts.admin')

@section('content')
    <h1> Edit Post</h1>
    <div class="col-sm-9">
    {!! Form::model($post, ['method'=>'PATCH', 'action'=>['AdminPostsController@update', $post->id], 'files'=>true]) !!}
    <div class="form-group">
        {!! Form::label('title', 'Title') !!}
        {!! Form::text('title', null, ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('category_id', 'Category') !!}
        {!! Form::select('category_id',  $categories, null, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('photo_id', 'File Upload') !!}
        {!! Form::file('photo_id', null, ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', 'Body') !!}
        {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>3]) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Update Post',  ['class'=>'btn btn-primary ']) !!}
    </div>

    {!! Form::close() !!}

    {!! Form::open(['method'=>'DELETE', 'action'=>['AdminPostsController@destroy', $post->id]]) !!}

    <div class="form-group">
        {!! Form::submit('Delete Post ',  ['class'=>'btn btn-danger ']) !!}
    </div>

    {!! Form::close() !!}
    </div>

    @include('includes.errors')
@endsection