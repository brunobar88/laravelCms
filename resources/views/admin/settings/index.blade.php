@extends('adminlte::page')

@section('title', 'configuração')

@section('content_header')
    <h1>Configurações</h1>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5><i class="icon fas fa-ban"></i> Você tem alguns Erros</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-success">
            {{ session('warning') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="{{ route('settings.save') }}" method="post" class="form-horizontal">
                @method('PUT') 
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Titulo do site</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $settings['title'] }}" name="title" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Subtitulo do site</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $settings['subTitle'] }}" name="subTitle" class="form-control">
                    </div>
                </div>  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ $settings['email'] }}" name="email" class="form-control">
                    </div>
                </div>  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Cor de fundo</label>
                    <div class="col-sm-10">
                        <input type="color" value="{{ $settings['bgColor'] }}" name="bgColor" class="form-control">
                    </div>
                </div>  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Cor do texto</label>
                    <div class="col-sm-10">
                        <input type="color" value="{{ $settings['textColor'] }}" name="textColor" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="submit" value="salvar" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection