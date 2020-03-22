@extends('adminlte::page')

@section('title', 'Nova Pagina')

@section('content_header')
    <h1>Nova Pagina</h1>
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

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pages.store') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Titulo</label>
                    <div class="col-sm-10">
                        <input name="title" value="{{ old('title') }}" type="text" class="form-control @error('title') is-invalid @enderror">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Corpo Pagina</label>
                    <div class="col-sm-10">
                        <textarea name="body" class="form-control bodyFild" {{ old('body') }}></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="submit" value="Criar" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea.bodyFild',
            heigth: 300,
            menubar: false,
            plugins: ['link', 'table', 'image', 'autoresize', 'lists'],
            toolbar: 'undo redo | formatselect | bold italic backcolor | aligncenter alignright alignleft alignjustify | table | link image | bulllist | numlist',
            content_css: [
                '{{ asset('assets/css/content.css') }}',
            ],
            images_upload_url: '{{ route('imageUpload') }}',
            images_upload_credentials: true,
            convert_url: false,
        });
    </script>
@endsection