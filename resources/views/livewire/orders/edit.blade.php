@section('head.title', 'Ordens | Atualizar')
@section('page.title', "Atualização da Ordem nº {$order->number}")

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('order.title') is-invalid @enderror">Título</label>
                    <div class="col-md-10">
                        <input class="form-control @error('order.title') is-invalid @enderror" placeholder="Lorem ipsum dolor sit amet" wire:model="order.title">
                        @error('order.title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('order.description') is-invalid @enderror">Descrição</label>
                    <div class="col-md-10">
                        <textarea style="resize: none" class="form-control @error('order.description') is-invalid @enderror" rows="4" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sit amet turpis scelerisque, varius ex mattis, euismod ex." wire:model="order.description"></textarea>
                        @error('order.description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label">Cliente</label>
                    <div class="col-md-10">
                        <select class="form-select @error('order.customer_id') is-invalid @enderror" wire:model="order.customer_id">
                            <option value="">Selecione</option>
                            @foreach($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                        @error('order.customer_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label">Endereço</label>
                    <div class="col-md-10">
                        <select class="form-select @error('order.address_id') is-invalid @enderror" wire:model="order.address_id">
                            <option value="">Selecione</option>
                            @foreach($addresses as $address)
                            <option value="{{$address->id}}">{{$address->postcode}}, {{$address->street}} - {{$address->number}}</option>
                            @endforeach
                        </select>
                        @error('order.address_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('total_value') is-invalid @enderror">Valor total (R$)</label>
                    <div class="col-md-10">
                        <input class="form-control @error('total_value') is-invalid @enderror" readonly id="currency-mask" placeholder="100,00" wire:model="total_value">
                        @error('total_value')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary w-md">Atualizar</button>
                        <a href="{{route('orders.index')}}" class="btn btn-danger w-md">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row align-items-start">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <input class="form-control" placeholder="Digite ao menos três letras do nome do serviço" wire:model="search">
                </div>
                <div class="card-body">
                    <table class="table align-middle table-nowrap table-responsive" id="items-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Tipo</th>
                                <th style="width: 100px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td>{{$item['name']}}</td>
                                <td>{{$item['value_formatted']}}</td>
                                <td>{{$item['type_formatted']}}</td>
                                <td style="text-align: center;">
                                    <a type="button" rel="tooltip" class="text-primary">
                                        <i class="fas fa-plus" wire:click="addItem({{$item->id}})"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4" align="center">Nenhuma informação a ser apresentada</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Produtos e Serviços Selecionados</h5>
                </div>
                <div class="card-body">
                    <table class="table align-middle table-nowrap" id="order-items-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Tipo</th>
                                <th style="width: 100px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($orderItems as $index => $item)
                            <tr>
                                <td>{{$item['name']}}</td>
                                <td>{{$item['value_formatted']}}</td>
                                <td>{{$item['type_formatted']}}</td>
                                <td style="text-align: center;">
                                    <a type="button" rel="tooltip" class="text-danger">
                                        <i class="fas fa-times" wire:click="removeItem({{$index}})"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="3" align="center">Nenhuma informação a ser apresentada</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script src="/assets/libs/imask/imask.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var currencyMask = IMask(document.getElementById('currency-mask'), {
            mask: 'num',
            blocks: {
            num: {
                    scale: 2,
                    mask: Number,
                    normalizeZeros: false,
                    thousandsSeparator: '.'
                }
            }
        });
    });
</script>
@endsection