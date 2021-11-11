@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <div class="row mt-5">
        <div class="card bg-dark col-md-12">
            <div class="card-header">UwUify</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="text" class="form-label">Je text</label>
                    <textarea class="form-control form-control-lg" id="uwuin" rows="3" placeholder="UwU in"></textarea>
                </div>
                <label for="text" class="form-label">Je UwU</label>
                <div class="input-group mb-3">
                    <textarea class="form-control form-control-lg" id="uwuout" rows="3"
                        placeholder="UwU out"></textarea>
                    <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#uwuModel"><i
                            class="far fa-copy"></i></button>
                </div>
                <button class="btn btn-primary"">UwUify!</button>
            </div>
        </div>
    </div> --}}
    <uwu-ify></uwu-ify>
</div>
@endsection
