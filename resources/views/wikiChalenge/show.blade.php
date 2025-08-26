@php
    use App\Services\Wiki;
@endphp

@extends('layouts.app')

@section('content')
@if($challenge->state == 2)
    <div class="content-box">
        <h1>Welkom op Wiki Search</h1>
        <p>Dit is een oude al afgeronde challenge. Maak een nieuwe challenge als je toch wilt spelen.</p>
    </div>
@else
    <div class="container" id="wiki">
        <div class="py-3">
            <div class="content-box">
                <h1>Welkom op Wiki Search</h1>
                <p>Bij dit spel moet je van Wikipedia pagina A naar Wikipedia pagina B navigeren in zo min mogelijk stappen. Je komt aan bij het doel door op de links te klikken en zo naar een volgende pagina te gaan. Aan het einde wordt je score opgeslagen zoen kunnen andere mensen het sneller proberen te doen.</p>
            </div>
            <div class="content-box p-3 mb-3">
                <h1>Pagina A: <span class="badge bg-primary">{{ $challenge->start }}</span></h1>
                <hr>
                <p class="m-0">{{ $wiki[0][1] }}</p>
            </div>
            <div class="content-box p-3 mb-3">
                <h1>Pagina B: <span class="badge bg-primary">{{ $challenge->end }}</span>
                </h1>
                <hr>
                <p>{{ $wiki[1][1] }}</p>
            </div>
            
            <div class="content-box d-flex justify-content-between align-items-center mb-3 p-3 rounded">
                <label for="sharable_link" class="form-label">Deel deze link:</label>
                <div class="input-group">
                    <input type="text" class="form-control" value="{{ URL::full() }}" readonly id="sharable_link" aria-describedby="invite link">
                    <button class="btn btn-secondary rounded-end" type="button"
                            onclick="navigator.clipboard.writeText({{ URL::full() }}); document.getElementById('copy-success').classList.remove('d-none'); setTimeout(() => document.getElementById('copy-success').classList.add('d-none'), 2000);">
                        <i class="fas fa-copy"></i>
                    </button>
                    <div id="copy-success"
                         class="d-none position-absolute top-50 start-50 translate-middle-x alert rounded alert-success text-dark py-1 px-2 mt-2">
                        het kopiëren is gelukt!
                    </div>
                </div>
            </div>

            <div class="content-box" id="app">
                <wiki-challenge-starter route="{{ route('challenge.start', $challenge) }}"
                                        :challenge="{{ json_encode($challenge->only('id', 'user_id')) }}"
                                        :me="{{ json_encode(auth()->user()->only('id', 'name')) }}" />
            </div>
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
@endif
@endsection
