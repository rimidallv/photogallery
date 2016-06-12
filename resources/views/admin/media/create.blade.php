@extends('layouts.admin')

@section('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">


@endsection

@section('content')

    <h1>Upload photo</h1>
{!! Form::open(['method'=>'POST', 'action'=>'AdminMediasController@store', 'class'=>'dropzone']) !!}


   {!! Form::close() !!}

@endsection

@include('includes.errors')

@section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
    @endsection