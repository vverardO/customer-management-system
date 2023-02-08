@section('head.title', 'Dashboard')
@section('page.title', 'Dashboard')

<div class="row justify-content-center">
<div class="col-xl-12">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-success alert-label-icon label-arrow" role="alert">
                            <i class="fas fa-calendar-week label-icon"></i>Clientes Novos (Semana): <strong>{{$weekCustomers}}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-primary alert-label-icon label-arrow" role="alert">
                            <i class="fas fa-calendar-alt label-icon"></i>Clientes Novos (Mês): <strong>{{$monthCustomers}}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-success alert-label-icon label-arrow" role="alert">
                            <i class="fas fa-calendar-alt label-icon"></i>Ordens de Serviço (Semana): <strong>{{$weekOrders}}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-primary alert-label-icon label-arrow" role="alert">
                            <i class="fas fa-calendar-alt label-icon"></i>Ordens de Serviço (Mês): <strong>{{$monthOrders}}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="text-center mb-5">
            <p class="text-muted mb-4" style="font-size: 25px;">Interface inicial, ainda em desenvolvimento com inserção dos seguintes gráficos:</p>
            <ul class="list-unstyled product-desc-list text-muted">
                <li><i class="mdi mdi-circle-medium me-1 align-middle"></i>Todos os clientes que estão por ser notificados;</li>
                <li><i class="mdi mdi-circle-medium me-1 align-middle"></i>Todos que foram notificados;</li>
                <li><i class="mdi mdi-circle-medium me-1 align-middle"></i>Total de clientes novos na última semana e último mês;</li>
                <li><i class="mdi mdi-circle-medium me-1 align-middle"></i>Total de ordens criadas na última semana e último mês;</li>
            </ul>
        </div>
    </div>
</div>