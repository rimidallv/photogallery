@extends('layouts.admin')

@section('content')
    <h1>Posts</h1>

    <table class="table">
        <thead>
        <tr>
            <th>Photo</th>
            <th>ID</th>
            <th>User</th>
            <th>Category</th>

            <th>Title</th>
            <th>Body</th>
            <th>Created_at</th>
            <th>Updated_at</th>
            <th>View Comments</th>
        </tr>
        </thead>
        <tbody>
        @if($posts)
            @foreach($posts as $post)
                <tr>
                    <td><img height="50" src="{{$post->photo ? $post->photo->file : ' no post photo'}}"</td>
                    <td>{{$post->id}}</td>


                    <td><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->user->name}}</a></td>
                    <td>{{$post->category ? $post->category->name : 'No category for this post'}}</td>

                    <td>{{$post->title}}</td>
                    <td>{{$post->body}}</td>
                    <td>{{$post->created_at}}</td>
                    <td>{{$post->updated_at}}</td>
                    <td><a href="{{route('admin.comments.show', $post->id)}}">View comments</a></td>
                    <td><a href="{{route('home.post', $post->slug)}}">View comments</a></td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>





@endsection