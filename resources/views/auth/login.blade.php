@extends('layouts.login')

@section('content')
<div>
    <a href="{{ route('home') }}"><i class="far fa-arrow-square-left icon-back-big"></i></a>
    <h2>INLOGGEN</h2>
    <form method="POST" action="{{ route('login') }}">
    @csrf
        <div class="form-group mb-3">
            <label for="email" class="col-form-label text-md-right">E-Mail Addres</label>
                <input id="email" type="email" class="form-control fs-5 @error('email') is-invalid @enderror"" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
        </div>

        <div class="form-group mb-3">
            <div class="w-100">
                <div class="row">
                    <div class="col-5">
                        <label for="password" class="col-form-label text-md-right">Wachtwoord</label>
                    </div>
                    @if (Route::has('password.request'))
                        <div class="col-sm-12 col-md-12 col-xl-7 text-xl-end">
                            <label for="" class="col-form-label">
                                <small>
                                    <a href="{{ route('password.request') }}">
                                        Wachtwoord Vergeten?
                                    </a>
                                </small>
                            </label>
                        </div>
                    @endif
                </div>
            </div>
                <input id="password" type="password" class="form-control fs-5 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Wachtwoord">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
        </div>

        <div class="form-group mb-3">
            <hr>
            <div class="form-check">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember"
                        id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        Onthoud Mij
                    </label>
                </div>
            </div>
            <hr>
        </div>

        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary w-100">
                Inloggen
            </button>
        </div>
        <div class="text-center">
            Nog geen account? <a href="{{ route('register') }}">Maak er een</a>!
        </div>
    </form>
</div>
@endsection
