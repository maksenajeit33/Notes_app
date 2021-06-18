@extends('layouts.app')

@section('content')

<div class="container">
    <div class="jumbotron container">
        <h1>Edit Your Note!</h1>
        <hr>
        <a class="btn btn-info btn-lg" href="{{route('notes.show', $note->id)}}" role="button">show note</a>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-info" role="alert">
        {{$message}}
    </div>
    @endif

    @if (count($errors))
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
        @endforeach
    @endif

    <form action="{{route('notes.update', $note->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" class="form-control" id="title" name="title" value="{{$note->title}}">
        </div>
        <div class="form-group">
          <label for="content">Content</label>
          <textarea class="form-control" id="content" name="content" rows="3">{{$note->content}}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">save</button>
        </div>
    </form>
</div>

@endsection
