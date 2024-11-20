@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-box mb-3">
            <div class="card-header">
                <h1 class="h5"><a href="{{ route('steam.review.all') }}"><i class="fas fa-angle-left pe-2"></i>terug</a> | Jou eigen reviews</h1>
            </div>
            @auth
                <hr />
                <div class="card-body">
                    <a href="{{ route('steam.review.all') }}">Bekijk alle reviews</a>
                </div>
            @endauth
        </div>
        <div class="row mb-3 gx-3">
            @if (! empty($reviews))
            @foreach ($reviews as $review)
            <div class="mb-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card px-0 bg-dark text-white h-100">
                    <img src="https://cdn.cloudflare.steamstatic.com/steam/apps/{{ $review->steam_appid }}/header.jpg" class="card-img-top" alt="{{ $review->name }}">
                    <div class="score ">
                        <h1 class="
                            @if ($review->recomended)bg-success
                            @else bg-danger
                            @endif text-white text-center mb-0 py-1 h2">
                            @if ($review->recomended):)
                            @else:(
                            @endif
                        </h1>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $review->name }}</h5>
                        <p class="card-text">"<em>{{ $review->review }}</em>"</p>
                        <p class="card-text">- {{ $review->user->name }}</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">{{ $review->playtime_forever }} Gespeeld <span class="float-end"><a class="" href="{{ route('steam.review.edit', [$user, $review]) }}"><i class="fas fa-edit"></i></a></span></small>
                    </div>
                </div>
            </div>
            @endforeach
            @else
                <div class="card mb-3 col-12">
                    <p>Er zijn geen reviews</p>
                </div>
            @endif
        </div>
    </div>
@endsection
