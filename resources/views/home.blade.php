@extends('layouts.app')

@section('content')
    <div class="has-background-image" style="background-image:url('https://source.unsplash.com/collection/175083/1920x1080')">
        <div class="container">
            <div class="row justify-content-center">
                <div class="row">
                    <div class="col-sm-12 my-3">
                        <div class="card quick-access-box">
                            <div class="card-header h4">
                                {{ $greeting }} {{ Auth()->user()->name }}!
                            </div>
                            <div class="card-body">
                            <form action="{{ route('home.search') }}" method="POST">
                                @csrf
                                <div class="input-group mb-3">
                                    <input name="search" type="text" class="form-control outline-primary" placeholder="Wat wil je weten?" autofocus>
                                    <button type="submit" class="btn btn-primary" type="button" id="button-addon2">Zoek</button>
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
                                <a href="https://translate.google.com"><i class="quick-access-logo pe-4 fas fa-language"></i></a>
                                <a href="https://maps.google.com"><i class="quick-access-logo pe-4 fas fa-globe-europe"></i></a>
                                <hr>
                            <p>Programmeren</p>
                                <a href="https://github.com"><i class="quick-access-logo pe-4 fab fa-github"></i></a>
                                <a href="https://figma.com"><i class="quick-access-logo pe-4 fab fa-figma"></i></a>
                                <a href="https://laravel.com"><i class="quick-access-logo pe-4 fab fa-laravel"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card quick-access-box mb-3">
                            <div class="card-header h4">
                                To Jas Or Not To Jas. That's the question.
                            </div>
                            <div class="card-body">
                                <h4>To Jas!</h4>
                                <p>och wat jammer het is kut weer</p>
                                <hr>
                                <p>En zo ziet de rest van de dag eruit:</p>
                                <i class="fas fa-sun"></i>
                                <i class="fas fa-smog"></i>
                                <i class="far fa-snowflake"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card quick-access-box mb-3">
                            <div class="card-header h4">
                                En dan nu het nieuws
                            </div>
                            <div class="card-body">
                                <h4>Katja Wonings nieuwe hond is dood D:</h4>
                                <p>Wat zielig </p>
                                <hr>
                                <p class="mb-0">En hier hebben we dit belangrijke bericht gevonden</p>
                                <p>Het internet</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
