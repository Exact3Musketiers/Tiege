@extends('layouts.login')

@section('content')
<div>
    <a href="{{ route('login') }}"><i class="far fa-arrow-square-left icon-back-big mb-3"></i></a>
    <h2 class="user-select-none" onclick="counter()">REGISTREREN</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group mb-3">
            <label for="name" class="col-form-label text-md-right">Naam</label>

            <input id="name" type="text" class="form-control fs-5 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Naam" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="name" class="col-form-label text-md-right">Lastfm Gebruikersnaam</label>

            <input id="lastfm" type="text" class="form-control fs-5 @error('lastfm') is-invalid @enderror" name="lastfm" value="{{ old('lastfm') }}" autocomplete="lastfm" placeholder="Lastfm" autofocus>

            @error('lastfm')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email" class="col-form-label text-md-right">E-Mail Address</label>

            <input id="email" type="email" class="form-control fs-5 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password" class="col-form-label text-md-right">Wachtwoord</label>

            <input id="password" type="password" class="form-control fs-5 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Wachtwoord">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password-confirm" class="col-form-label text-md-right">Bevestig Wachtwoord</label>

            <input id="password-confirm" type="password" class="form-control fs-5" name="password_confirmation" required autocomplete="new-password" placeholder="Bevestig Wachtwoord">
        </div>

        <div id="musketier" class="form-group mb-3 hidden-input">
            <label for="musketier-password" class="col-form-label text-md-right">Musketier Wachtwoord</label>

            <input id="musketier-password" type="password" class="form-control fs-5" name="password_musketier" placeholder="???">
        </div>

        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary w-100">
                Registreer
            </button>
        </div>
    </form>
</div>

<script>
    var i = 0;
    function counter() {
        i++;
        if (i === 10) {
            document.getElementById('musketier').classList.remove('hidden-input')
        }
    }
</script>
@endsection
