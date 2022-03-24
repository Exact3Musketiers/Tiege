@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="card bg-dark text-white col-md-12">
                <div class="card-header">
                    <h1 class="h5">Alle steam gebruikers</h1>
                </div>
                <hr class="m-0">
                <div class="card-body">
                    @if (count($users) > 0)
                        <p>Selecteer een steam gebruiker om die persoons account om die persoons profiel te bekijken</p>
                        <ul class="list-group text-white list-group-item-dark">
                            @foreach ($users as $user)
                                <a href="{{ route('steam.show', $user) }}" class="list-group-item list-group-item-action ">{{ $user->name }}</a>
                            @endforeach
                        </ul>
                    @else
                        <p class="m-0">Die zijn er nog niet...</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
