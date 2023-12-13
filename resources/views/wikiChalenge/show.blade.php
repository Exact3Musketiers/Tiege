@php
    use App\Services\Wiki;
@endphp

@extends('layouts.app')

@section('content')
<div class="container" id="wiki">
    <div class="py-3">
        <h1>Welkom op Wiki Search</h1>
        <p>Bij dit spel moet je van Wikipedia pagina A naar Wikipedia pagina B navigeren in zo min mogelijk stappen. Je komt aan bij het doel door op de links te klikken en zo naar een volgende pagina te gaan. Aan het einde wordt je score opgeslagen zoen kunnen andere mensen het sneller proberen te doen.</p>
        <div class="bg-dark rounded p-3 mb-3">
            <h1>Pagina A: <span class="badge bg-primary">{{ $challenge->start }}</span></h1>
            <hr>
            <p class="m-0">{{ $wiki[0][1] }}</p>
        </div>
        <div class="bg-dark rounded p-3 mb-3">
            <h1>Pagina B: <span class="badge bg-primary">{{ $challenge->end }}</span>
            </h1>
            <hr>
            <p>{{ $wiki[1][1] }}</p>
        </div>
        <div class="bg-dark d-flex justify-content-between align-items-center mb-3 p-3 rounded">
            <p class="text-truncate pe-3 mb-0"><strong>Deel deze link:</strong> <span id="sharable_link">{{ URL::full() }}</span></p>
            <a class="btn btn-primary btn-sm text-light" id="copy_link"><i class="far fa-copy"></i></a>
        </div>
        {{-- <form method="POST" action="{{ route('wiki.store', ['challenge_id' => $challenge->getKey()]) }}">
            @csrf
            <button class="btn btn-success fs-4 px-2"><strong>Start!</strong></button>
        </form> --}}
        <wiki-challenge-starter route="{{ route('challenge.start', $challenge) }}" me="{{json_encode(auth()->user()->toArray())}}"></wiki-challenge-starter>
    </div>
</div>
<script>
    let button = document.getElementById('copy_link');
    button.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(document.getElementById('sharable_link').innerHTML);
        } catch (err) {
            console.error(err.name, err.message);
        }
    });
</script>
@endsection
