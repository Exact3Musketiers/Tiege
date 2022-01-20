@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="card bg-dark col-md-12">
                <div class="card-header">Voeg Steam toe aan Profiel</div>
                <hr>
                <div class="card-body">
                    @error('form')
                        @dd($errors)
                    @enderror
                    <form action="{{ route('profile.update', $profile) }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="mb-3">
                            <label for="steamid" class="form-label">Voeg je Steamid toe</label>
                            <input type="number" class="form-control" name="steamid" value="{{ old('steamid', (isset($profile->steamid)) ? $profile->steamid : '') }}" id="steamid" aria-describedby="steamid" placeholder="bijv.: 1234567890">
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


