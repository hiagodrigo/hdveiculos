@extends('veiculos.index')

@section('title', $veiculo->marca)

@section('content')

    <div class="col-md-10 offset-mdf-1">
        <div class="row">
            <div id="image-container" class="col-md-6">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach (json_decode($veiculo->fotos) as $index => $foto)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}" @if($index == 0) class="active" @endif></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach (json_decode($veiculo->fotos) as $index => $foto)
                        <div class="carousel-item @if($index == 0) active @endif">
                            @if (filter_var($foto, FILTER_VALIDATE_URL))
                            <img src="{{ $foto }}" class="d-block w-100" alt="{{ $veiculo->marca }}">
                            @else
                            <img src="/img/veiculos/{{ $foto }}" class="d-block w-100" alt="{{ $veiculo->marca }}">
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
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
