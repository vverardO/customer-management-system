@section('head.title', 'Usuários | Listagem')
@section('page.title', 'Usuários')

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="search-box ms-2">
                            <div class="position-relative">
                                <input type="text" class="form-control rounded bg-light border-0" wire:model.debounce.500ms="search" placeholder="Buscar por nome, email ou perfil de acesso">
                                <i class="mdi mdi-magnify search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-inline float-md-end mb-3">
                        <a href="{{route('users.create')}}" class="btn btn-success waves-effect waves-light">
                            <i class="mdi mdi-plus me-2"></i> Novo Usuário
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4">
                <table class="table table-centered table-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Perfil de Acesso</th>
                            <th style="width: 150px;">Data Criação</th>
                            <th style="width: 50px;text-align: center;">Status</th>
                            <th style="width: 100px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->accessRole->title}}</td>
                            <td>{{$user->created_at->format('d/m/Y H:i:s')}}</td>
                            @if($user->id == auth()->user()->id)
                                <td style="text-align: center;">
                                    <a type="button" rel="tooltip" class="text-secondary" disabled>
                                        <i class="fas fa-user-slash"></i>
                                    </a>
                                </td>
                            @else
                                <td style="text-align: center;">
                                    @if($user->status == 0)
                                        <a type="button" rel="tooltip" wire:click="grantAccess({{$user->id}})" class="text-success" title="Autorizar">
                                            <i class="fas fa-user-check"></i>
                                        </a>
                                    @else
                                        <a type="button" rel="tooltip" wire:click="revokeAccess({{$user->id}})" class="text-danger" title="Revogar">
                                            <i class="fas fa-user-slash"></i>
                                        </a>
                                    @endif
                                </td>
                            @endif
                            <td>
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <a href="{{route('users.edit', ['id' => $user->id])}}" class="px-2 text-primary"><i class="bx bx-pencil font-size-18"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#" wire:click="destroy('User', {{$user->id}})" class="px-2 text-danger"><i class="bx bx-trash-alt font-size-18"></i></a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" align="center">Nenhuma informação a ser apresentada</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
