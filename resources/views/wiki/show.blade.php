@extends('layouts.app')

@section('content')
<div class="w-100 p-3 text-center text-secondary">
    <nav aria-label="breadcrumb">
        <h1>{{ $wiki->start }} <i class="fas fa-long-arrow-alt-right"></i> {{ $wiki->end }}</h1>
    </nav>
</div>
<div class="container">
    <div class="py-3">
        {!! $body !!}
        </small>
    </div>
</div>

@endsection
