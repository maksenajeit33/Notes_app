@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                <hr>
                <div class="card-body">
                    <a href="{{route('notes.index')}}" class="btn btn-primary">All Notes</a>
                    <a href="{{route('notes.create')}}" class="btn btn-success">Create Note</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
