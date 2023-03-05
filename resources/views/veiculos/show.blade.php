@extends('veiculos.index')

@section('title', $veiculo->marca)

@section('content')

    <div class="col-md-10 offset-mdf-1">
        <div class="row">
            <div id="image-container" class="col-md-6">
                <img src="/img/veiculos/{{ $veiculo->foto }}" class="img-fluid" alt="{{ $veiculo->marca }}">
            </div>
            <div id="info-container" class="col-md-6">
                <h1>{{ $veiculo->marca . '/' . $veiculo->modelo }}</h1>
                <p class="event-city">
                    <ion-icon name="bookmark-outline"></ion-icon>Espécie/Tipo: {{ $veiculo->especie . '/' . $veiculo->tipo }}
                </p>
                <p class="event-city">
                    <ion-icon name="bookmarks-outline"></ion-icon>Marca/Modelo:
                    {{ $veiculo->marca . '/' . $veiculo->modelo }}
                </p>
                <p class="event-city">
                    <ion-icon name="color-palette-outline"></ion-icon>Cor: {{ $veiculo->cor }}
                </p>
                <p class="event-city">
                    <ion-icon name="speedometer-outline"></ion-icon>Potência: {{ $veiculo->potencia }}
                </p>
                <p class="event-city">
                    <ion-icon name="calendar-outline"></ion-icon>Ano: {{ $veiculo->ano }}
                </p>

                <p class="events-participants">
                    <ion-icon name="people-outline"></ion-icon>Pessoas interessadas: {{ count($veiculo->users) }}
                </p>

                <p class="event-owner">
                    <ion-icon name="star-outline"></ion-icon>{{ $donoAnuncio['name'] }}
                </p>
                @if (!$hasUserJoined)
                    <form action="/veiculos/join/{{ $veiculo->id }}" method="POST">
                        @csrf
                        <a href="/events/join/{{ $veiculo->id }}" class="btn btn-success" id="event-submit"
                            onclick="event.preventDefault();
                this.closest('form').submit();">
                            Confirmar Interesse
                        </a>
                    </form>
                @else
                    <p class="already-joined-msg">Você já demonstrou interesse nesse veículo!</p>
                @endif
                @if ($veiculo->opcionais != null)
                    <h3>O veículo possui os seguintes opcionais:</h3>
                    <ul id="items-list">
                        @foreach ($veiculo->opcionais as $item)
                            <li>
                                <ion-icon name="play-outline"></ion-icon><span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

@endsection
