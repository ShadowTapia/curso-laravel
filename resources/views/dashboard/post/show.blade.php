@extends('dashboard.layout')

@section('content')
<h1>{{ $post->title }}</h1>

<div>{{$post->posted}}</div>

<div>{{ $post->description }}</div>

<div>{{$post->content}}</div>


@endsection
