@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$note->title}}</h5>
                    <p class="card-text">{{$note->content}}</p>
                    <blockquote class="blockquote mb-0">
                        <footer class="blockquote-footer">Created at • {{$note->created_at->diffForHumans()}}</footer>
                        <footer class="blockquote-footer">Updated at • {{$note->updated_at->diffForHumans()}}</footer>
                    </blockquote>
                </div>
                <hr>
                <div class="card-body">
                    <a href="{{route('notes.edit', $note->id)}}" class="btn btn-info">Edit note</a>
                    <a href="{{route('notes.index')}}" class="btn btn-primary">All notes</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
