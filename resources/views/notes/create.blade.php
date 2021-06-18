@extends('layouts.app')

@section('content')

<div class="container">
    <div class="jumbotron container">
        <h1>Create Your Note!</h1>
        <hr>
        <a class="btn btn-primary btn-lg" href="{{route('notes.index')}}" role="button">All notes</a>
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

    <form action="{{route('notes.store')}}" method="POST">
        @csrf
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" class="form-control" id="title" name="title" placeholder="Your title" value="{{old('title')}}">
        </div>
        <div class="form-group">
          <label for="content">Content</label>
          <textarea class="form-control" id="content" name="content" rows="3">{{old('content')}}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>

@endsection
