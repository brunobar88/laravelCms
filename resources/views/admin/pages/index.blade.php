@extends('adminlte::page')

@section('title', 'Paginas')

@section('content_header')
    <h1>Minhas paginas <a href="{{ route('pages.create') }}" class="btn btn-sm btn-success">+ Nova pagina</a></h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="50">ID</th>
                    <th>Titulo</th>
                    <th width="200" >Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td>{{ $page->id }}</td>
                        <td>{{ $page->title }}</td>
                        <td>
                            <a href="" target="_blank" class="btn btn-sm btn-success">Ver</a>
                        <a href="{{ route('pages.edit', [ $page->id ]) }}" class="btn btn-sm btn-info">Editar</a>
                        <form class="d-inline" action="{{ route('pages.destroy', [ $page->id ]) }}" method="post" onsubmit="return confirm('tem certeza que deseja excluir?')">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-sm btn-danger" type="submit" >Exluir</button>
                        </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{ $pages->links() }}
@endsection