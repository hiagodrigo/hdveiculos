@extends('veiculos.index')

@section('title', 'Meu Cadastro')

@section('content')

    <div class="col-md-10 offset-md-1 dashboard-title-container">
        <h1>Meus Anúncios</h1>
    </div>
    <div class="col-md-10 offset-md-1 dashboard-events-container">
        @if (isset($veiculos) && count($veiculos) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Interesses</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($veiculos as $veiculo)
                        <tr>
                            <td scropt="row">{{ $loop->index + 1 }}</td>
                            <td><a href="/veiculos/{{ $veiculo->id }}">{{ $veiculo->marca . '/' . $veiculo->modelo }}</a></td>
                            <td>{{ $veiculo->users()->count() }}</td>
                            <td>
                                <a href="/veiculos/{{ $veiculo->id }}/edit" class="btn btn-info edit-btn">
                                    <ion-icon name="create-outline"></ion-icon>Editar
                                </a>
                                <form action="/veiculos/{{ $veiculo->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-btn ml-1">
                                        <ion-icon name="trash-outline"></ion-icon>Deletar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Você ainda não veículos cadastrados, <a href="/veiculos/create">cadastrar veículo</a></p>
        @endif
    </div>
    <div class="col-md-10 offset-md-1 dashboard-title-container">
        <h1>Veículos que estou interessado</h1>
    </div>
    <div class="col-md-10 offset-md-1 dashboard-events-container">
        @if (count($veiculosInteresse) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Marca/Modelo</th>
                        <th scope="col">Interesses</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($veiculosInteresse as $veiculo)
                        <tr>
                            <td scropt="row">{{ $loop->index + 1 }}</td>
                            <td><a href="/veiculos/{{ $veiculo->id }}">{{ $veiculo->marca . '/' . $veiculo->modelo }}</a></td>
                            <td>{{ count($veiculo->users) }}</td>
                            <td>
                                <form action="/veiculos/leave/{{ $veiculo->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-btn">
                                        <ion-icon name="trash-outline"></ion-icon>
                                        Tirar interesse
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Você ainda demonstrou interesse em nenhum veículo, <a href="/">veja todos os veículos disponíveis</a>
            </p>
        @endif
    </div>


@endsection
