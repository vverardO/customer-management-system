@section('head.title', 'Entrada de Produto | Cadastro')
@section('page.title', 'Realizar uma Entrada de Produto')

<div class="row">
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label">Nome do Produto</label>
                    <div class="col-md-10">
                        <select class="form-select @error('entry.item_id') is-invalid @enderror" wire:model="entry.item_id">
                            <option>Selecione</option>
                            @foreach($items as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('entry.quantity') is-invalid @enderror">Quantidade</label>
                    <div class="col-md-10">
                        <input class="form-control @error('entry.quantity') is-invalid @enderror" placeholder="1" wire:model="entry.quantity">
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary w-md">Realizar Entrada</button>
                        <a href="{{route('entries.index')}}" class="btn btn-danger w-md">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
