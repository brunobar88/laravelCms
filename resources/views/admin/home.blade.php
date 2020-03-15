@extends('adminlte::page')

@section('plugins.Chartjs', true)

@section('title', 'painel')

@section('content_header')
    <div class="row">
        <div class="col-md-6">
            <h1>Dashboard</h1>
        </div>
        <div class="col-md-6">
            <form class="float-md-right" onchange="this.submit()" action="{{ route('admin') }}" method="get">
                <label for="datePeriod">Periodo das visitas:</label>
                <select name="datePeriod" id="datePeriod">
                    <option {{$selected === 30 ? 'selected="selected"' : ''}} value="30">Ultimos 30 dias</option>
                    <option {{$selected ===60 ? 'selected="selected"' : ''}} value="60">Ultimos 2 meses</option>
                    <option {{$selected === 90 ? 'selected="selected"' : ''}} value="90">Ultimos 3 meses</option>
                    <option {{$selected === 120 ? 'selected="selected"' : ''}} value="120">Ultimos 4 meses</option>
                </select>
            </form>
        </div>
    </div>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$visitCount}}</h3>
                    <p>Visitas</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-eye"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$onlineCount}}</h3>
                    <p>Usuarios on-line</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-heart"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$pageCount}}</h3>
                    <p>Paginas</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-sticky-note"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$userCount}}</h3>
                    <p>Usuarios</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-user"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Paginas mais visitadas</h3>
                </div>
                <div class="card-body">
                    <canvas id="canvaPie"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sobre o sistema</h3>
                </div>
                <div class="card-body">
                    ...
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        window.onload = function() {
            let ctx = document.getElementById('canvaPie').getContext('2d');
            window.canvaPie = new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                        data: {!! $pageValues !!},
                        backgroundColor: '#0000FF',
                    }],
                    labels: {!! $pageLabels !!},
                },
                options: {
                    responsive: true,
                    legend: {
                        display: false,
                    },
                },
            });
        }
    </script>
@endsection