@extends('layouts.app')

@php
    $explode_location = explode(',', $profile->location);
    $location =  ['city' => $explode_location[0] ?? null, 'country' => $explode_location[1] ?? null];
@endphp

@section('content')
    <div class="container">
        @include('includes._errors')

        <div class="row mt-5">
            <div class="card bg-dark col-md-12">
                <div class="card-header">Voeg Steam toe aan Profiel</div>
                <hr>
                <div class="card-body">
                    <form action="{{ route('profile.update', $profile) }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="mb-3">
                            <label for="steamid" class="form-label">Voeg je Steamid toe</label>
                            <input type="number" class="form-control" name="steamid"
                                   value="{{ old('steamid', (isset($profile->steamid)) ? $profile->steamid : '') }}"
                                   id="steamid" aria-describedby="steamid" placeholder="bijv.: 1234567890">
                        </div>
                        <button type="submit" class="btn btn-primary">Sla op</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="card bg-dark col-md-12">
                <div class="card-header">Voeg je locatie toe</div>
                <hr>
                <div class="card-body">
                    <form action="{{ route('profile.update', $profile) }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-8">
                                    <label for="city" class="form-label">Stad</label>
                                    <input type="text" class="form-control" name="city" value="{{ old('city') ?? $location['city'] }}">
                                </div>
                                <div class="col-4">
                                    <label for="country" class="form-label">Land</label>
                                    <select class="form-select" name="country">
                                        <option selected value="">Kies een land</option>
                                        @foreach($countries as $country)
                                            <option @if(!empty(old('country')) && $country['short_name'] === old('country'))
                                                        selected
                                                    @elseif(empty(old('country')) && $location['country'] === $country['short_name'])
                                                        selected
                                                    @endif value="{{ $country['short_name'] }}">
                                                {{ $country['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Sla op</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="card bg-dark col-md-12">
                <div class="card-header">Profiel Verwijderen</div>
                <hr>
                <div class="card-body">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        Remove account
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        You will not be able to reverse deleting your account.
                        Are you sure?
                    </div>
                    <form method="POST" action="{{ route('profile.destroy', $profile)}}">
                        @method('DELETE')
                        @csrf
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" typeof="submit">Delete account</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection


