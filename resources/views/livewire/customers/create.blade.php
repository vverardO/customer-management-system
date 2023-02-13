@section('head.title', 'Clientes | Cadastrar')
@section('page.title', 'Cadastrar um Cliente')

<div class="col-lg-12">
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
    <div class="row align-items-start">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Adicionar um endereço</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">CEP</label>
                        <div class="col-md-6">
                            <input class="form-control" placeholder="97010400" wire:model="postcode">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-success waves-effect waves-light" wire:click="getAddress">
                                <i class="fas fa-search-location"></i>
                            </button>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-success waves-effect waves-light" wire:click="pushAddress">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Cidade</label>
                        <div class="col-md-9">
                            <input class="form-control" placeholder="Santa Maria" wire:model="address.city">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Estado</label>
                        <div class="col-md-9">
                            <input class="form-control" placeholder="Rio de Janeiro" wire:model="address.state">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Bairro</label>
                        <div class="col-md-9">
                            <input class="form-control" placeholder="São José" wire:model="address.neighborhood">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Rua</label>
                        <div class="col-md-9">
                            <input class="form-control" placeholder="Rua das Macieiras" wire:model="address.street">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Número</label>
                        <div class="col-md-9">
                            <input class="form-control" placeholder="100" wire:model="address.number">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Complemento</label>
                        <div class="col-md-9">
                            <input class="form-control" placeholder="Apartamento, sala, conjunto, edifício, andar, etc." wire:model="address.complement">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Endereços</h5>
                </div>
                <div class="card-body">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            <tr>
                                <th>Cep</th>
                                <th>Rua</th>
                                <th>Número</th>
                                <th>Complemento</th>
                                <th style="width: 10px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($customerAddresses as $index => $address)
                            <tr>
                                <td>{{$address['postcode']}}</td>
                                <td>{{$address['street']}}</td>
                                <td>{{$address['number'] ?? ""}}</td>
                                <td>{{$address['complement'] ?? ""}}</td>
                                <td style="text-align: center;">
                                    <a type="button" rel="tooltip" class="text-danger">
                                        <i class="fas fa-times" wire:click="removeAddress({{$index}})"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" align="center">Nenhuma informação a ser apresentada</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>