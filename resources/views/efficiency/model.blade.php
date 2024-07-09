@extends('layouts.app')

@section('content')
    @dump($errors->all())
    <div class="container">
        <div class="py-3">
            <h1>{{ $car->brand .' '. $car->model }}</h1>
            <div class="row pt-3 mb-3">
                <div class="card bg-dark text-white col-12">
                    <div class="card-header">
                        <h1 class="h5"><a href="{{ route('driving.index') }}"><i class="fas fa-angle-left pe-2"></i>terug</a> | Pas je review aan</h1>
                    </div>
                    <hr class="m-0">
                    <div class="card-body">
                        <form action="{{ $stat->getActionRoute(routeModels: $car) }}" method="post">
                            @if($stat->exists)
                                @method('PATCH')
                            @endif
                            @csrf
                            <div class="mb-3">
                                <label for="odo_reading" class="form-label">Kilometerstand</label>
                                <input class="form-control" name="odo_reading" id="odo_reading" value="{{ old('odo_reading') ?? $stat->odo_reading }}"  placeholder="Kilometerstand" type="number">
                            </div>
                            <div class="mb-3">
                                <label for="liters_tanked" class="form-label">Liters getankt</label>
                                <input class="form-control" name="liters_tanked" id="liters_tanked" value="{{ old('liters_tanked') ?? $stat->liters_tanked }}"  placeholder="Liters getankt" type="number" step="0.01">
                            </div>
                            <div class="mb-3">
                                <label for="price_per_liter" class="form-label">Prijs per liter</label>
                                <input class="form-control" name="price_per_liter" id="price_per_liter" value="{{ old('price_per_liter') ?? $car->price_per_liter }}"  placeholder="Prijs per liter" type="number" step="0.001" >
                            </div>
                            <div class="mb-3">
                                <label for="record_date" class="form-label">Datum</label>
                                <input class="form-control" name="record_date" id="record_date" value="{{ old('record_date') ?? $car->record_date }}"  placeholder="Datum" type="date">
                            </div>
                            <button type="submit" class="btn btn-outline-primary w-100">Opslaan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

