@php
    use App\Models\RefuelingStat
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="py-3">
            <h1>{{ $car->brand .' '. $car->model }}</h1>
            <p>Houd hier bij hoe efficient je auto is. Vul in hoeveel je tankt en hoeveel kilometers en hoeveel kilometer je hebt gereden> Je kan ook je auto toevoegen Als je dat leuk lijkt!</p>
{{--@dump($stats)--}}
            <table class="table table-dark table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Gereden (km)</th>
                        <th scope="col">Getankt (l)</th>
                        <th scope="col">Gebruik (km/l)</th>
                        <th scope="col">Datum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stats as $stat)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $stat->odo_reading }}</td>
                            <td>{{ RefuelingStat::convertToFloat($stat->liters_tanked ) }}</td>
                            <td>{{ RefuelingStat::convertToFloat($stat->usage) }}</td>
                            <td>{{ $stat->record_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('efficiency.create', $car) }}" class="btn btn-primary text-light mt-3">Voeg tankbeurt toe</a>
    </div>
@endsection
