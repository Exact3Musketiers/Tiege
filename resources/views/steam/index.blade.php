@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="card bg-dark col-md-12">
                @foreach ($users as $user)
                    <a href="{{ route('steam.show', $user) }}">{{ $user->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
