@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="card bg-dark col-md-12">
                <div class="card-header">sARcASMify je SHit!</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="text" class="form-label">Je text</label>
                        <input type="text" class="form-control" placeholder="Vul hier uw text in" id="text">
                    </div>
                    <label for="text" class="form-label">Je sarcasme</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="vUL HIEr uw texT in" id="sarcasm">
                        <button class="btn btn-secondary" type="button"  id="copyButt" data-bs-toggle="modal" data-bs-target="#sarcasmModal"><i class="far fa-copy"></i></button>
                    </div>
                    <button class="btn btn-primary" id="sarcasmButt">Sarcasmify!</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="sarcasmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Uw tEXt IS gEkOpIeErd</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times" style="font-size: 20px;"></i></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="{{ asset("images/sarcasm.jpg" )}}" width="300px" class="rounded" alt="sARCasm.pnG">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go forth and sarcasm!</button>
                </div>
            </div>
        </div>
    </div>

<script>
    sarcasmify();
    copyURL();
</script>
@endsection

