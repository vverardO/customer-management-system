@section('head.title', 'Produtos | Atualizar')
@section('page.title', "Atualização do Produto {$product->name}")

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
                    <label class="col-md-2 col-form-label @error('product.warning') is-invalid @enderror">Quandidade para aviso</label>
                    <div class="col-md-10">
                        <input class="form-control @error('product.warning') is-invalid @enderror" placeholder="10" wire:model="product.warning">
                        @error('product.warning')
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
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label">Quantidade</label>
                    <div class="col-md-10">
                        <input class="form-control" readonly placeholder="30" wire:model="product.quantity">
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