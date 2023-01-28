@section('page.title', 'Acesso')

<div class="card">
    <div class="card-body p-4"> 
        <div class="text-center mt-2">
            <h5 class="text-primary">Seja bem vindo!</h5>
            <p class="text-muted">Entre com o seu email e senha.</p>
        </div>
        <div class="p-2 mt-4">
            <form wire:submit.prevent="login">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input wire:model="email" type="text" autofocus class="form-control @error('email') is-invalid @enderror" placeholder="antonio@gmail.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input wire:model="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="******">
                </div>
                <div class="mt-3 text-center">
                    <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Acessar</button>
                </div>
                <div class="mt-4 text-center">
                    <p class="mb-0">Não possui acesso?
                        <a href="{{ route('register') }}" class="fw-medium text-primary">Cadastrar</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>