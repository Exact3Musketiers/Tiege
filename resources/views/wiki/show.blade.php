@extends('layouts.app')

@section('content')
<div class="w-100 p-3 text-center">
    <div aria-label="breadcrumb">
        <h1 class="text-secondary">{{ $wiki->start }} <i class="fas fa-long-arrow-alt-right"></i> {{ $wiki->end }}</h1>
        <h3>Stappen tot nu toe: {{ $count }}</h3>
    </div>
</div>
<div class="container">
    <div class="py-3">
        {!! $body !!}
    </div>
</div>

@endsection
