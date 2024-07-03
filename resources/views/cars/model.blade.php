@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="py-3">
            <h1>Auto Efficiency</h1>
            <p>Houd hier bij hoe efficient je auto is. Vul in hoeveel je tankt en hoeveel kilometers en hoeveel kilometer je hebt gereden> Je kan ook je auto toevoegen Als je dat leuk lijkt!</p>
            <div class="row pt-3 mb-3">
                <div class="card bg-dark text-white col-12">
                    <div class="card-header">
                        <h1 class="h5"><a href="{{ route('driving.index') }}"><i class="fas fa-angle-left pe-2"></i>terug</a> | Pas je review aan</h1>
                    </div>
                    <hr class="m-0">
                    <div class="card-body">
                        <form action="{{ $car->getActionRoute() }}" method="post" enctype="multipart/form-data">
                            @if($car->exists)
                                @method('PATCH')
                            @endif
                            @csrf
                            @include('includes._errors')
                            <div class="mb-3 row">
                                <div class="col-6">
                                    <label for="brand" class="form-label">Merk</label>
                                    <input class="form-control" name="brand" value="{{ old('brand') ?? $car->brand }}" id="brand" placeholder="Merk">
                                </div>
                                <div class="col-6">
                                    <label for="model" class="form-label">Model</label>
                                    <input class="form-control" name="model" id="model"  value="{{ old('model') ?? $car->model }}"  placeholder="Model">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="year" class="form-label">Jaar</label>
                                <input class="form-control" name="year" id="year" value="{{ old('year') ?? $car->year }}"  placeholder="Jaar" type="number">
                            </div>
                            <div class="mb-3">
                                <label for="total_distance" class="form-label">Gereden afstand</label>
                                <input class="form-control" name="total_distance" id="total_distance" value="{{ old('total_distance') ?? $car->total_distance }}"  placeholder="Gereden afstand" type="number">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Afbeelding</label>
                                <input class="form-control form-control" name="image" id="image" type="file">
                            </div>
                                @if(!is_null($car->image_path))
                                    <div class="mb-3" style="width: 200px">
                                        <p class="form-label">Huidige afbeelding</p>
                                        <img class="rounded img-fluid" src="{{ $car->get_image() }}" alt="">
                                    </div>
                                @endif
                            <button type="submit" class="btn btn-outline-primary w-100">Opslaan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

