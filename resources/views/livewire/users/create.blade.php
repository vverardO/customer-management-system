@section('head.title', 'Usuários | Cadastrar')
@section('page.title', 'Cadastrar um Usuário')

<div class="row">
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('user.name') is-invalid @enderror">Nome</label>
                    <div class="col-md-10">
                        <input class="form-control @error('user.name') is-invalid @enderror" placeholder="Antonio" wire:model="user.name">
                        @error('user.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('user.email') is-invalid @enderror">Email</label>
                    <div class="col-md-10">
                        <input class="form-control @error('user.email') is-invalid @enderror" placeholder="Galpão I" wire:model="user.email">
                        @error('user.email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('user.password') is-invalid @enderror">Senha</label>
                    <div class="col-md-10">
                        <input class="form-control @error('user.password') is-invalid @enderror" placeholder="******" wire:model="user.password">
                        @error('user.password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label">Perfil de Acesso</label>
                    <div class="col-md-10">
                        <select class="form-select @error('user.access_role_id') is-invalid @enderror" wire:model="user.access_role_id">
                            <option>Selecione</option>
                            @foreach($accessRoles as $accessRole)
                            <option value="{{$accessRole->id}}">{{$accessRole->title}}</option>
                            @endforeach
                        </select>
                        @error('user.access_role_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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