@section('head.title', 'Ordens | Atualizar')
@section('page.title', "Atualização da Ordem nº{$order->id}")

<div class="row">
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
                        <select class="form-select @error('order.customer_id') is-invalid @enderror" wire:model="order.customer_id" wire:change="$emit('productChanged')">
                            <option>Selecione</option>
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
                <div class="row text-center mt-4">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary w-md">Atualizar</button>
                        <a href="{{route('orders.index')}}" class="btn btn-danger w-md">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>