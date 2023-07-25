@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-3">
        <h1>Gelukt!!! Je bent er!</h1>
        <h2>Je hebt er {{ $count }} stappen over gedaan.</h2>
        <h3>{{ $wiki->start }} <i class="fas fa-long-arrow-alt-right"></i> {{ $wiki->end }}</h3>

    </div>
</div>
