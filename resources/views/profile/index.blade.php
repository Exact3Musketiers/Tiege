@extends('layouts.app')

@section('content')

    <div>
        <h1>Profiel</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            Remove account
        </button>

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
                    <form method="POST" action="{{ route('profile.destroy')}}">
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


