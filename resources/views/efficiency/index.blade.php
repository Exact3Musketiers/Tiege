@php
    use App\Models\RefuelingStat;

    $total = RefuelingStat::calculateTotal($stats);
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="py-3">
            <h1>{{ $car->brand .' '. $car->model }}</h1>
            <p>Houd hier bij hoe efficient je auto is. Vul in hoeveel je tankt en hoeveel kilometers en hoeveel kilometer je hebt gereden> Je kan ook je auto toevoegen Als je dat leuk lijkt!</p>
            <table class="table table-dark table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Gereden (km)</th>
                        <th scope="col">Getankt (l)</th>
                        <th scope="col">Gebruik (km/l)</th>
                        <th scope="col">Prijs (per l)</th>
                        <th scope="col">Datum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stats as $stat)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $stat->odo_reading }}</td>
                            <td>{{ RefuelingStat::convertToFloat($stat->liters_tanked ) }}</td>
                            <td>{{ RefuelingStat::convertToFloat($stat->usage) }}</td>
                            <td>{{ RefuelingStat::convertToFloat($stat->price_per_liter) }}</td>
                            <td>{{ $stat->record_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="row">Totaal:</th>
                        <th>{{ $car->total_distance }} km</th>
                        <th>{{ $total['liters_tanked'] }} l</th>
                        <th>{{ round(RefuelingStat::convertToFloat($car->avg_usage), 1) }} km/l</th>
                        <th>&#8364;{{ $total['price'] }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <a href="{{ route('efficiency.create', $car) }}" class="btn btn-primary text-light mt-3">Voeg tankbeurt toe</a>
    </div>
@endsection
