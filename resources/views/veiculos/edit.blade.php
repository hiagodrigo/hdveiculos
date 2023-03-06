@extends('veiculos.index')

@section('title', 'Editando veículos')

@section('content')

    <div class="signup-form">
        <form action="/veiculos/{{ $veiculo->id }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h2>Edite seu anúncio</h2>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-car"></i></span>
                    <input type="text" class="form-control" name="especie" value="{{ $veiculo->especie }}"
                        required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-motorcycle"></i></span>
                    <input type="text" class="form-control" name="tipo" value="{{ $veiculo->tipo }}"
                        required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bus"></i></span>
                    <input type="text" class="form-control" name="marca" value="{{ $veiculo->marca }}"
                        required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-rocket"></i></span>
                    <input type="text" class="form-control" name="modelo" value="{{ $veiculo->modelo }}"
                        required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    <input type="text" class="form-control" name="cor" value="{{ $veiculo->cor }}"
                        required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-wrench"></i></span>
                    <input type="text" class="form-control" name="potencia" value="{{ $veiculo->potencia }}"
                        required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" class="form-control" name="ano" value="{{ $veiculo->ano }}"
                        required="required">
                </div>
            </div>
            <div class="form-group" id="create">
                <div class="input-group">
                    <p><span class="input-group-addon"><i class="fa fa-thumb-tack"></i></span>Opcionais:</p>
                    <div class="input-group">
                        <input type="checkbox" name="opcionais[]" value="Direção Hidráulica" class="checkbox"> Direção
                        Hidráulica
                    </div>
                    <div class="input-group">
                        <input type="checkbox" name="opcionais[]" value="Câmbio Automático" class="checkbox"> Câmbio
                        Automático
                    </div>
                    <div class="input-group">
                        <input type="checkbox" name="opcionais[]" value="Teto Solar" class="checkbox"> Teto Solar
                    </div>
                    <div class="input-group">
                        <input type="checkbox" name="opcionais[]" value="Ar Condicionado" class="checkbox"> Ar Condicionado
                    </div>
                    <div class="input-group">
                        <input type="checkbox" name="opcionais[]" value="Roda de Liga Leve" class="checkbox"> Roda de Liga
                        Leve
                    </div>
                </div>
            </div>
            <div class="form-group" id="create">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-file-image-o"></i></span>
                    <p>Foto(s) do Veículo</p>
                    @foreach (json_decode($veiculo->fotos) as $foto)
                        @if (filter_var($foto, FILTER_VALIDATE_URL))
                            <img src="{{ $foto }}" class="d-block w-100" alt="{{ $veiculo->marca }}">
                        @else
                            <img src="/img/veiculos/{{ $foto }}" class="d-block w-100" alt="{{ $veiculo->marca }}">
                        @endif
                    @endforeach
                    <input type="file" name="fotos[]" id="fotos" multiple>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Alterar anúncio</button>
            </div>
        </form>
    </div>

@endsection
