@extends('layouts.admin')

@section('content')

    <h1>Categories</h1>

    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Created</th>
        </tr>
        </thead>
        @if($categories)
        @foreach($categories as $category)
            <tbody>
            <tr>
                <td>{{$category->id}}</td>
                <td><a href="{{route('admin.categories.edit', $category->id)}}">{{$category->name}}</a></td>
                <td>{{$category->created_at}}</td>
            </tr>
            @endforeach
            @endif
            </tbody>
    </table>
@endsection

@include('includes.errors')