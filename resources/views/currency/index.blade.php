@extends('layouts.app')

@section('content')
    @include('includes._errors', ['bag' => 'form-feedback'])

    @if (isset($currencies))
        <h1 class="text-center mt-5">Currency Exchange</h1>
        <form method="POST" id="currencyForm" action="{{ route('currency.fetch') }}">
            @csrf
            <div class="form-group row">
                <label for="amount" class="col-md-4 col-form-label text-end">{{ __('Amount') }}</label>

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

            <div class="form-group row mb-0">
                <label for="from" class="col-md-4 col-form-label text-end">{{ __('From') }}</label>
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-select" id="from" name="from">
                            @foreach ($currencies->results as $currency)
                                <option
                                    value="{{ $currency->id }}" {{ (old('from') === $currency->id || $from === $currency->id) ? 'selected' : '' }}>{{ $currency->currencyName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-8 offset-md-8">
                    <button type="button" id="switchButton" onclick="switchCurrency()" class="btn btn-primary">
                        <i class="fas fa-repeat-alt"></i>
                    </button>
                </div>
            </div>

            <div class="form-group row mt-0">
                <label for="to" class="col-md-4 col-form-label text-end">{{ __('To') }}</label>
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-select" id="to" name="to">
                            @foreach ($currencies->results as $currency)
                                <option
                                    value="{{ $currency->id }}" {{ (old('to') === $currency->id || $to === $currency->id) ? 'selected' : '' }}>{{ $currency->currencyName }}</option>
                            @endforeach
                        </select>
                    </div>
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
    @else
        <div class="jumbotron text-center mt-5">
            <h1>Op dit moment is de currency service offline.</h1>
            <h2>Probeer het later opnieuw.</h2>
            <h3>Als je wil.</h3>
            <h4>Het hoeft niet hoor.</h4>
            <h5>Het zou wel fijn zijn.</h5>
        </div>
    @endif
@endsection

<script>
    function switchCurrency() {
        let from = document.getElementById('from');
        let to = document.getElementById('to');
        const _ = from.value.toString();
        for (let i = 0; i < from.options.length; i++) {
            if (from.options[i].value == to.value)
                from[i].selected = true;
        }
        for (let i = 0; i < to.options.length; i++) {
            if (to.options[i].value == _)
                to[i].selected = true;
        }
    }
</script>

<style>
    #currencyForm input {
        width: 500px;
    }

    #currencyForm select {
        width: 500px;
    }

    #switchButton {
        width: 60px;
        height: 40px;
    }

    #switchButton i {
        font-size: 18px;
    }
</style>
