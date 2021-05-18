@extends('layouts.app')

@section('content')
    <div class="has-background-image"
         style="background-image:url('https://source.unsplash.com/collection/175083/1920x1080')">
        <div class="container">
            <div class="row justify-content-center">
                <div class="row">
                    <div class="col-lg-8 col-md-12 my-3 float-start d-grid">
                        <div class="card quick-access-box">
                            <div class="card-header h4">
                                {{ $greeting }} {{ Auth()->user()->name }}!
                            </div>
                            <div class="card-body">
                                <form action="{{ route('home.search') }}" method="POST">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input name="search" type="text" class="form-control outline-primary"
                                               placeholder="Wat wil je weten?" autofocus>
                                        <button type="submit" class="btn btn-primary" type="button" id="button-addon2">
                                            Zoek
                                        </button>
                                    </div>
                                </form>
                                <hr>
                                <p>Lekker chillen</p>
                                <a href="https://youtube.com"><i class="quick-access-logo pe-4 fab fa-youtube"></i></a>
                                <a href="https://twitch.tv"><i class="quick-access-logo pe-4 fab fa-twitch"></i></a>
                                <a href="https://reddit.com"><i class="quick-access-logo pe-4 fab fa-reddit"></i></a>
                                <hr>
                                <p>Handige spulletjes</p>
                                <a href="https://gmail.com"><i class="quick-access-logo pe-4 fas fa-envelope"></i></a>
                                <a href="https://translate.google.com"><i
                                        class="quick-access-logo pe-4 fas fa-language"></i></a>
                                <a href="https://maps.google.com"><i
                                        class="quick-access-logo pe-4 fas fa-globe-europe"></i></a>
                                <hr>
                                <p>Programmeren</p>
                                <a href="https://github.com"><i class="quick-access-logo pe-4 fab fa-github"></i></a>
                                <a href="https://figma.com"><i class="quick-access-logo pe-4 fab fa-figma"></i></a>
                                <a href="https://laravel.com"><i class="quick-access-logo pe-4 fab fa-laravel"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="float-end col-lg-4 col-md-12 mt-3">
                        <div class="card mb-3">
                            <img src="{{ asset("images/sarcasm.jpg" )}}" class="img-thumbnail" alt="...">
                        </div>

                        <div class="card quick-access-box mb-3">
                            <div class="card-header h4">
                                To Jas Or Not To Jas. That's the question.
                            </div>
                            <div class="card-body">
                                @if(isset($weather['error']))
                                    <p>{{ $weather['error'] }}</p>
                                @else
                                    <h4>{{ ($weather['toJas']) ? 'To Jas :(' : 'Not To Jas!' }}</h4>
                                    <p>{{ ($weather['toJas']) ? 'Ook jammer.' : 'Wat een feest! Het is warm!' }}</p>
                                    <hr>
                                    <p>Het is nu namelijk {{ $weather['temperature'] }} °C En het word
                                        maximaal {{ $weather['temperatureMax'] }} °C</p>
                                    <hr>
                                    <p>Het is op dit moment {{ $weather['type'] }} </p>
                                    <hr>
                                    <p>Er is een {{ $weather['windText'] }} uit het {{ $weather['windDirection'] }}
                                        van {{ $weather['windBft'] }} bft </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 float-start">
                        <div class="card quick-access-box mb-3">
                            <div class="card-header h4">
                                En dan nu het nieuws
                            </div>
                            <div class="card-body row">
                                @if (isset($news['error']))
                                    {{$news['error']}}
                                @else
                                    @foreach ($news['articles'] as $article)
                                        <div class="col-lg-6 col-md-12">

                                            <span><strong>{{ $article->title }}</strong> - <a
                                                    href="{{ $article->url }}">link</a>
                                        </span>
                                            <hr>
                                        </div>

                                    @endforeach
                                    <div class="m-0">
                                            <span class="float-start"><a href="#"
                                                                         class="text-start">Lees meer</a></span>
                                        <span class="float-end">Geupdatet: {{ $news['updatedAt'] }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
