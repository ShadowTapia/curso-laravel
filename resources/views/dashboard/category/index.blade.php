@extends('dashboard.layout')

@section('content')

    <a class="my-2 btn btn-primary" href="{{ route("category.create") }}">Crear</a>

    <table class="table">
        <thead>
            <tr>
                <th>Titulo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $c)
            <tr>
                <td>{{ $c->title }}</td>
                <td>
                    <a class="my-2 btn btn-success" href="{{ route("category.edit", $c) }}">Editar</a>
                    <a class="my-2 btn btn-primary" href="{{ route("category.show", $c) }}">Ver</a>
                    <form action="{{ route("category.destroy", $c) }}" method="POST">
                        @method("DELETE")
                        @csrf
                        <button class="my-2 btn btn-danger" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
@endsection
