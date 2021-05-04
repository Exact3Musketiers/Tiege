@extends('layouts.app')

@section('content')
    hallo
    @include('random.includes.coin')
    @include('random.includes.rng')
    @include('random.includes.dice')

@endsection
