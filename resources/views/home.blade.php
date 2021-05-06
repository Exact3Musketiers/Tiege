@extends('layouts.app')

@section('content')
    <div class="has-background-image" style="background-image:url('https://source.unsplash.com/random/1920x1080')">
        <div class="row justify-content-center">
            <div class="alert align-middle w-75 quick-access-box mt-5">
                <h4 class="alert-heading">Gegroet {{ Auth()->user()->name }}!</h4>
                <p>Hier zijn de apps waar jij altijd van kan genieten.</p>
                <hr>
                <form action="{{ route('home.search') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input name="search" type="text" class="form-control" placeholder="Wat wil je weten?">
                        <button type="submit" class="btn btn-outline-secondary" type="button" id="button-addon2">Zoek</button>
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
@endsection
