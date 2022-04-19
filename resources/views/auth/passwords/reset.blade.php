@extends('layouts.login')

@section('content')
<div>
    <a href="{{ route('login') }}"><i class="far fa-arrow-square-left icon-back-big"></i></a>
    <h2>Reset Wachtwoord</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group mb-3">
            <label for="email" class="col-form-label text-md-right">E-Mail Address</label>

            <input id="email" type="email" class="form-control fs-5 @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" placeholder="Email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password" class="col-form-label text-md-right">Wachtwoord</label>

            <input id="password" type="password" class="form-control fs-5 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Nieuw Wachtwoord">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password-confirm" class="col-form-label text-md-right">Bevestig Wachtwoord</label>

            <input id="password-confirm" type="password" class="form-control fs-5" name="password_confirmation" required autocomplete="new-password" placeholder="Bevestig Nieuw Wachtwoord">
        </div>

        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary">
                Reset Wachtwoord
            </button>
        </div>
    </form>
</div>
@endsection
