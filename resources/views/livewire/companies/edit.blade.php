@section('head.title', 'Empresa')
@section('page.title', "Atualização da Empresa {$company->name}")

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('company.name') is-invalid @enderror">Nome da Empresa</label>
                    <div class="col-md-10">
                        <input class="form-control @error('company.name') is-invalid @enderror" placeholder="Galpão I" wire:model="company.name">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('company.identificator') is-invalid @enderror">Identificador</label>
                    <div class="col-md-10">
                        <input class="form-control @error('company.identificator') is-invalid @enderror" placeholder="75.434.311/0001-68" wire:model="company.identificator">
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary w-md">Atualizar</button>
                        <a href="{{redirect()->back()->getTargetUrl()}}" class="btn btn-danger w-md">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>