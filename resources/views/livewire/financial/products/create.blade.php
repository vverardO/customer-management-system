@section('head.title', 'Produtos | Cadastrar')
@section('page.title', 'Cadastrar um Produto')

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('product.name') is-invalid @enderror">Nome do Produto</label>
                    <div class="col-md-10">
                        <input class="form-control @error('product.name') is-invalid @enderror" placeholder="Ajuste na caixa d'água" wire:model="product.name">
                        @error('product.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('value') is-invalid @enderror">Valor (R$)</label>
                    <div class="col-md-10">
                        <input id="currency-mask" class="form-control @error('value') is-invalid @enderror" placeholder="1,00" wire:model="value">
                        @error('value')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                        <a href="{{route('products.index')}}" class="btn btn-danger w-md">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('script')
<script src="/assets/libs/imask/imask.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Pattern (Phone)
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