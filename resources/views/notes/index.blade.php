@extends('layouts.app')

@section('content')

@if (count($notes))
<div class="container">
    <div class="jumbotron container">
        <h1>All Notes!</h1>
        <hr>
        <a class="btn btn-primary btn-lg" href="{{route('notes.create')}}" role="button">Create note</a>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-info" role="alert">
        {{$message}}
    </div>
    @endif

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Created at</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
            @endphp
            @foreach ($notes as $item)
            <tr>
                <th scope="row">{{++$i}}</th>
                <td>{{$item->title}}</td>
                <td>{{$item->created_at->diffForhumans()}}</td>
                <td>
                    <a href="{{route('notes.edit', $item->id)}}" class="btn btn-info">Edit</a>
                    <a href="{{route('notes.show', $item->id)}}" class="btn btn-success">Show</a>
                    <form action="{{route('notes.destroy', $item->id)}}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- PAGINATION --}}
    @if ($notes->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            @if ($notes->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $notes->previousPageUrl() }}">Previous</a>
                </li>
            @endif
            @if ($notes->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $notes->nextPageUrl() }}">Next</a></li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next</a>
                </li>
            @endif
        </ul>
    </nav>
    @endif

</div>
@else
<div class="alert alert-warning" role="alert">
    There is no note!
</div>
@endif

@endsection
