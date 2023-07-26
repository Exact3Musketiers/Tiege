@extends('layouts.app')

@section('content')
<div class="container text-center confetti">
    <div class="d-flex flex-col min-vh-100 align-items-center">
        <div class="py-3 mx-auto">
            <h1 class="rainbow_text_animated">Gelukt!!! Je bent er!</h1>
            <h2>Je hebt er {{ $count }} stappen over gedaan.</h2>
            <h3>{{ $wiki->start }} <i class="fas fa-long-arrow-alt-right"></i> {{ $wiki->end }}</h3>
            <a class="btn btn-primary" href="{{ route('wiki.index') }}">Ga terug naar start</a>
        </div>
    </div>
</div>
@endsection()
