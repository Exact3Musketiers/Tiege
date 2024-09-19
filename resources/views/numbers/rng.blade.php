@extends('layouts.app')

@section('content')
    <div class="container">
        @include('numbers.includes.coin')
        @include('numbers.includes.rng')
        @include('numbers.includes.dice')
    </div>
@endsection
