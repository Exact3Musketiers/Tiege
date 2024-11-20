@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-box">
            @if (count($users) > 0)
                <h1>Welkom op Steam searcher</h1>
                <p>Selecteer een steam gebruiker wiens proefiel je wilt bekijken.</p>
                <ul class="list-group text-white">
                    @foreach ($users as $user)
                        <a href="{{ route('steam.show', $user) }}" class="list-group-item list-group-item-action ">{{ $user->name }}</a>
                    @endforeach
                </ul>
            @else
                <p class="m-0">Die zijn er nog niet...</p>
            @endif
        </div>
    </div>
@endsection
