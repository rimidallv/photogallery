@extends('layouts.admin')

@section('content')

    <h1>Media</h1>

    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Created</th>
        </tr>
        </thead>
        @if($photos)
            @foreach($photos as $photo)
                <tbody>
                <tr>
                    <td>{{$photo->id}}</td>
                    <td><img height="50" src="{{$photo->file}}"></td>
                    <td>{{$photo->created_at}}</td>
                    <td>
                        {!! Form::open(['method'=>'DELETE', 'action'=>['AdminMediasController@destroy', $photo->id]]) !!}

                         <div class="form-group">
                             {!! Form::submit('Delete Image',  ['class'=>'btn btn-primary ']) !!}
                         </div>

                           {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
                @endif
                </tbody>
    </table>
@endsection

@include('includes.errors')