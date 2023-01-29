@section('head.title', 'Clientes | Cadastrar')
@section('page.title', 'Cadastrar um Cliente')

<div class="row">
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('customer.name') is-invalid @enderror">Nome</label>
                    <div class="col-md-10">
                        <input class="form-control @error('customer.name') is-invalid @enderror" placeholder="antonio" wire:model="customer.name">
                        @error('customer.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('customer.general_record') is-invalid @enderror">RG</label>
                    <div class="col-md-10">
                        <input class="form-control @error('customer.general_record') is-invalid @enderror" placeholder="7289382761" wire:model="customer.general_record">
                        @error('customer.general_record')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('customer.registration_physical_person') is-invalid @enderror">CPF</label>
                    <div class="col-md-10">
                        <input class="form-control @error('customer.registration_physical_person') is-invalid @enderror" placeholder="950.425.060-20" wire:model="customer.registration_physical_person">
                        @error('customer.registration_physical_person')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                        <a href="{{route('customers.index')}}" class="btn btn-danger w-md">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>