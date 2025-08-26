@extends('layouts.app')

@php
    $explode_location = explode(',', $profile->location);
    $location =  ['city' => $explode_location[0] ?? null, 'country' => $explode_location[1] ?? null];
@endphp

@section('content')
    <div class="container">
        @include('includes._errors')

        <div class="content-box mb-3">
            <label for="invite_link" class="form-label">Tige delen? Gebruik deze link</label>
            <div class="input-group">
                <input type="text" class="form-control" value="https://tige.site/register?invite={{ config('services.inviteCode') }}" readonly id="invite_link" aria-describedby="invite link">
                <button class="btn btn-secondary rounded-end" type="button"
                        onclick="navigator.clipboard.writeText('https://tige.site/register?invite={{ config('services.inviteCode') }}'); document.getElementById('copy-success').classList.remove('d-none'); setTimeout(() => document.getElementById('copy-success').classList.add('d-none'), 2000);">
                    <i class="fas fa-copy"></i>
                </button>
                <div id="copy-success"
                     class="d-none position-absolute top-50 start-50 translate-middle-x alert rounded alert-success text-dark py-1 px-2 mt-2">
                    het kopiëren is gelukt!
                </div>
            </div>
        </div>

        <div>
            <div class="content-box">

            </div>
            <div class="content-box">
                <h1>Pas jezelf aan</h1>
                <hr />
                <form action="{{ route('profile.update', $profile) }}" method="post">
                    @method('patch')
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Pas je naam aan</label>
                        <input type="text" class="form-control" name="name"
                               value="{{ old('name', (isset($profile->name)) ? $profile->name : '') }}"
                               id="name" aria-describedby="name" placeholder="bijv.: Johannes de Vries">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Pas je email aan</label>
                        <input type="text" class="form-control" name="email"
                               value="{{ old('email', (isset($profile->email)) ? $profile->email : '') }}"
                               id="email" aria-describedby="email" placeholder="bijv.: email@provider.nl">
                    </div>
                    <div class="mb-3">
                        <label for="steamid" class="form-label">Beheer je Steamid</label>
                        <input type="number" class="form-control" name="steamid"
                               value="{{ old('steamid', (isset($profile->steamid)) ? $profile->steamid : '') }}"
                               id="steamid" aria-describedby="steamid" placeholder="bijv.: 1234567890">
                    </div>
                    <div class="mb-3">
                        <label for="lastfm" class="form-label">Beheer je lastfm koppeling</label>
                        <input type="text" class="form-control" name="lastfm"
                               value="{{ old('lastfm', (isset($profile->lastfm)) ? $profile->lastfm : '') }}"
                               id="lastfm" aria-describedby="lastfm" placeholder="Johannes_de_vries24">
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-8">
                                <label for="city" class="form-label">Stad</label>
                                <input type="text" class="form-control" name="city" value="{{ old('city') ?? $location['city'] }}" placeholder="Harkema">
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
                            @if(!empty($location['city']))
                                <a class="pt-1 ps-" href="#" onclick="event.preventDefault(); document.removeLocation.submit()">Verwijder je locatie</a>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sla op</button>
                </form>
                <form name="removeLocation" class="d-none" action="{{ route('profile.update', $profile) }}" method="post">
                    @method('patch')
                    @csrf
                    <input type="hidden" name="city">
                    <input type="hidden" name="country">
                </form>
            </div>
        </div>

        <div class="mt-3">
            <div class="content-box">
                <h1>Kies je achtergrond</h1>
                <hr>
                <div class="card-body">
                    <form action="{{ route('profile.update', $profile) }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="mb-3 row gap-y-2 row-gap-3">
                            <label for="steamid" class="form-label">Selecteer een van de onderstaande afbeeldingen</label>
                            <div class="col-lg-4 col-md-6 col-12">
                                <input type="radio" name="background_image" value="0" id="image_radio_0" class="btn-check" />
                                <label class="ratio ratio-16x9 btn" for="image_radio_0">
                                    <div class="rounded-1 justify-content-center align-items-center d-flex">Geen achtergrond</div>
                                </label>
                            </div>
                            @foreach ($images as $image)
                                <div class="col-lg-4 col-md-6 col-12">
                                    <input type="radio" name="background_image" value="{{ $loop->iteration }}" id="image_radio_{{ $loop->iteration }}" class="btn-check" />
                                    <label class="ratio ratio-16x9 btn" for="image_radio_{{ $loop->iteration }}">
                                        <img  src="{{ $image}}" class="rounded-1" alt="Achtergrond foto optie {{ $loop->iteration }}">
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">Sla op</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="my-3">
            <div class="content-box">
                <div class="card-header">Profiel Verwijderen</div>
                <hr>
                <div class="card-body">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        Account verwijderen
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Weet je het zeker?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Deze actie kan niet worden teruggedraaid
                    </div>
                    <form method="POST" action="{{ route('profile.destroy', $profile)}}">
                        @method('DELETE')
                        @csrf
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" typeof="submit">Account verwijderen</button>
                            <button type="button" class="btn btn-light text-dark" data-bs-dismiss="modal">Annuleer</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection


