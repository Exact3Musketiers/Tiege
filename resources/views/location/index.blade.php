@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="py-3">
            <div class="content-box mb-3">
                <h1>Beheer Cyber Guesser locaties</h1>
            </div>
        </div>
        <div class="content-box">
            <a href="{{ route('location.create') }}" class="btn btn-primary text-light mb-3">Voeg locatie toe</a>
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>thumbnail</th>
                            <th>Naam</th>
                            <th>Lat-Lon</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 150px"><img src="{{ asset('/images/brammen/donder_bram.png') }}" alt="bram" style="width: 50px" class="img-responsive rounded" /></td>
                            <td>Bram</td>
                            <td>lat lon</td>
                            <td class="text-end">edit</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
