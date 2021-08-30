@extends('layouts.app')

@section('content')
    <div class="container">
        @include('random.includes.coin')
        @include('random.includes.rng')
        @include('random.includes.dice')
    </div>
@endsection
