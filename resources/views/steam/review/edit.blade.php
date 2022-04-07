@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pt-5 mb-3">
            <div class="card bg-dark text-white col-12">
                <div class="card-header">
                    <h1 class="h5"><a href="{{ route('steam.review.index', $user) }}"><i class="fas fa-angle-left pe-2"></i>terug</a> | Pas je review aan</h1>
                </div>
                <hr class="m-0">
                <div class="card-body">
                    <form action="{{ route('steam.update', [$user, $review]) }}" method="post">
                        @method('PATCH')
                        @csrf
                        @include('includes._errors')
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <label class="form-check-label" for="recomendedSwitch">aanbevelen</label>
                                    <input class="form-check-input" type="checkbox" name="recomended" id="recomendedSwitch"
                                        @if ((empty(old()) && $review->recomended) || array_key_exists('recomended', old())) checked @endif
                                    >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="feedback" class="form-label">Wat vond je van {{ $review->name }}?</label>
                                <textarea class="form-control" name="review" id="feedback" rows="3" placeholder="Ik vind {{ $review->name }}...">{{ old('review') ?? $review->review }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-primary w-100">update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
