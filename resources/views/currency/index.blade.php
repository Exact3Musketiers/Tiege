@extends('layouts.app')

@section('content')
    <h1 class="text-center">Currency Exchange</h1>
    <form method="POST" action="{{ route('fetch') }}">
        @csrf

        <div class="form-group row">
            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>

            <div class="col-md-6">
                <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount"
                       value="{{ old('amount') != null ? old('amount') : $amount }}" required autofocus>

                @error('amount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="from" class="col-md-4 col-form-label text-md-right">{{ __('From') }}</label>

            <div class="col-md-6">
                <input id="from" type="text" class="form-control @error('from') is-invalid @enderror" name="from"
                       value="{{ old('from') != null ? old('from') : $from }}" required autofocus>
                @error('from')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="to" class="col-md-4 col-form-label text-md-right">{{ __('To') }}</label>

            <div class="col-md-6">
                <input id="to" type="text" class="form-control @error('to') is-invalid @enderror" name="to"
                       value="{{ old('to') != null ? old('to') : $to }}" required autofocus>

                @error('to')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Calculate') }}
                </button>
            </div>
        </div>
    </form>
    <div class="jumbotron text-center">
        <h3>{{$amount . ' ' . $from}} = </h3>
        <h1>{{$result}}</h1>
    </div>
@endsection
