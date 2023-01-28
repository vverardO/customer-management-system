@section('page.title', 'Registrar')

<div class="card">
    <div class="card-body p-4"> 
        <div class="text-center mt-2">
            <h5 class="text-primary">Seja bem vindo!</h5>
            <p class="text-muted">Cadastre-se.</p>
        </div>
        <div class="p-2 mt-4">
            <form wire:submit.prevent="register">
                <div class="mb-3">
                    <label class="form-label">Nome da empresa</label>
                    <input type="text" wire:model="company_name" autofocus class="form-control @error('company_name') is-invalid @enderror"  placeholder="fulano's company">
                    @error('company_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">CNPJ da empresa</label>
                    <input type="text" wire:model="company_identificator" class="form-control @error('company_identificator') is-invalid @enderror"  placeholder="75.434.311/0001-68">
                    @error('company_identificator')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Nome do usuário</label>
                    <input type="text" wire:model="user_name" class="form-control @error('user_name') is-invalid @enderror"  placeholder="antonio">
                    @error('user_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email de acesso</label>
                    <input  type="email" wire:model="user_email" class="form-control @error('user_email') is-invalid @enderror" placeholder="antonio@gmail.com">        
                    @error('user_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" wire:model="user_password" class="form-control @error('user_password') is-invalid @enderror"  placeholder="******">        
                    @error('user_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mt-3 text-center">
                    <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Registrar</button>
                </div>
                <div class="mt-4 text-center">
                    <p class="mb-0">Já possui cadastro?
                        <a href="{{ route('login') }}" class="fw-medium text-primary">Acessar</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>