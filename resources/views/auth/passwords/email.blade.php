@extends('layouts.login')

@section('content')
<div>
    <a href="{{ route('login') }}"><i class="far fa-arrow-square-left icon-back-big"></i></a>
    <h2>Reset Wachtwoord</h2>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group mb-3">
            <label for="email" class="col-form-label text-md-right">E-Mail Address</label>

                <input id="email" type="email" class="form-control fs-5 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>

        <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary w-100">
                    Verstuur De Wachtwoord Reset Link
                </button>
        </div>
    </form>
</div>
@endsection
