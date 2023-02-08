@section('head.title', 'OS | Listagem')
@section('page.title', 'Ordens de Serviço')

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="search-box ms-2">
                            <div class="position-relative">
                                <input type="text" class="form-control rounded bg-light border-0" wire:model.debounce.500ms="search" placeholder="Buscar pelo número, título, nome do cliente ou descrição">
                                <i class="mdi mdi-magnify search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-inline float-md-end mb-3">
                        <a href="{{route('orders.create')}}" class="btn btn-success waves-effect waves-light">
                            <i class="mdi mdi-plus me-2"></i> Nova Ordem de Serviço
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4">
                <table class="table table-centered table-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nº</th>
                            <th>Título</th>
                            <th>Cliente</th>
                            <th title="Apresentação limitada em 50 caractéres">Descrição</th>
                            <th style="width: 100px;">Valor Total (R$)</th>
                            <th style="width: 100px;text-align: center;">Serviços</th>
                            <th style="width: 200px;text-align: center;">Data Criação</th>
                            <th style="width: 100px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{$order->number}}</td>
                            <td>{{$order->title}}</td>
                            <td>{{$order->customer->name}}</td>
                            <td>{{$order->description_limited}}</td>
                            <td style="text-align: right;">{{$order->total_value_formatted}}</td>
                            <td style="text-align: right;">{{$order->services_count}}</td>
                            <td style="text-align: center;">{{$order->created_at->format('d/m/Y H:i:s')}}</td>
                            <td>
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <a href="{{route('orders.edit', ['id' => $order->id])}}" class="px-2 text-primary"><i class="bx bx-pencil font-size-18"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#" wire:click="destroy('Order', {{$order->id}})" class="px-2 text-danger"><i class="bx bx-trash-alt font-size-18"></i></a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" align="center">Nenhuma informação a ser apresentada</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>