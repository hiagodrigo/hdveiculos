<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        @yield('title', 'HD Veículos')
    </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merienda+One">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/styles.css" type="text/css">
    <script src="/js/app.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-xl navbar-light bg-light">
        <a href="/" class="navbar-brand"><img src="/img/logo.png" alt="HD Veículos"></a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Collection of nav links, forms, and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
            <div class="navbar-nav">
                <a href="/" class="nav-item nav-link active">Home</a>
                <a href="/veiculos/create" class="nav-item nav-link">Crie seu anúncio</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Veículos</a>
                    <div class="dropdown-menu">
                        <a href="/?search=Automóveis" class="dropdown-item">Automóveis</a>
                        <a href="/?search=Motocicletas" class="dropdown-item">Motocicletas</a>
                        <a href="/?search=Utilitários" class="dropdown-item">Utilitários</a>
                        <a href="/?search=Camionetas" class="dropdown-item">Camionetas</a>
                    </div>
                </div>
            </div>
            <form class="navbar-form form-inline">
                <div class="input-group search-box">
                    <form action="/" method="get">
                        <input type="text" id="search" name="search" class="form-control" placeholder="Procurar">
                        <span class="input-group-addon"><i class="material-icons">&#xE8B6;</i></span>
                    </form>
                </div>
            </form>
            @auth
                <div class="navbar-nav ml-auto">
                    <div class="nav-item dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action"
                            style="margin-right: 110px"> {{ auth()->user()->name }} <b class="caret"></b></a>
                        <div class="dropdown-menu">
                            <a href="/dashboard" class="dropdown-item"><i class="fa fa-user-o"></i> Meus anúncios</a></a>
                            <a href="{{ route('profile.show') }}" class="dropdown-item"><i class="fa fa-sliders"></i> Meus
                                dados</a></a>
                            <div class="dropdown-divider"></div>
                            <form action="/logout" method="POST">
                                @csrf
                                <a href="/logout" class="dropdown-item"
                                    onclick="event.preventDefault();
                        this.closest('form').submit();"><i
                                        class="material-icons">&#xE8AC;</i> Logout</a></a>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
            @guest
                <div class="navbar-nav ml-auto">
                    <div class="navbar-nav">
                        <a href="/login" class="nav-item nav-link">Entrar</a>
                        <a href="/register" class="nav-item nav-link">Cadastrar</a>
                    </div>
                </div>
            @endguest
        </div>
    </nav>

    <main>
        <div class="container-fluid">
            <div class="row">
                @if (session('msg'))
                    <p class="msg">{{ session('msg') }}</p>
                @endif
            </div>
        </div>
        @if ($errors->any())
            <h2>Houve alguns erros ao processar o formulário</h2>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @yield('content')
    </main>

    @if (Request::is('/'))
        <div class="container-xl" id="carousel">
            <div class="row">
                <div class="col-md-12">
                    @if (isset($search))
                        <h2>Buscando por: <b>{{ $search }}</b></h2>
                    @else
                        <h2>Galeria <b>Ouro</b></h2>
                    @endif
                    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
                        <!-- Carousel indicators -->
                        <ol class="carousel-indicators">
                            @php
                                //determinando quantidade de items retornado, para controlar quantidade de items do carousel
                                $numPaginas = ceil(count($veiculos) / 4);
                            @endphp
                            @if ($numPaginas <= 1)
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            @else
                                @for ($i = 0; $i < $numPaginas; $i++)
                                    <li data-target="#myCarousel" data-slide-to="{{ $i }}"
                                        class="{{ $i == 0 ? 'active' : '' }}"></li>
                                @endfor
                            @endif

                        </ol>
                        <!-- Wrapper for carousel items -->
                        <div class="carousel-inner">
                            <div class="item carousel-item active">
                                <div class="row">

                                    @foreach ($veiculos as $veiculo)
                                        @if ($loop->first or $loop->iteration <= 4)
                                            @php
                                                //gerando estrelas automaticamente, futuramente update para recuperar do banco
                                                $stars = rand(0, 5);
                                            @endphp
                                            <div class="col-sm-3">
                                                <div class="thumb-wrapper">
                                                    <span class="wish-icon">
                                                        @if (auth()->user() &&
                                                                auth()->user()->veiculosInteresse->contains($veiculo->id))
                                                            <form action="/veiculos/leave/{{ $veiculo->id }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <i class="fa fa-heart"
                                                                    onclick="event.preventDefault();this.closest('form').submit();"></i>
                                                    </span>
                                                    </form>
                                                @else
                                                    <form action="/veiculos/join/{{ $veiculo->id }}" method="post">
                                                        @csrf
                                                        <i class="fa fa-heart-o"
                                                            onclick="event.preventDefault();this.closest('form').submit();"></i>
                                                    </form>
                                        @endif
                                        </span>
                                        <div class="img-box">
                                            <img src="/img/veiculos/{{ $veiculo->foto }}" class="img-fluid"
                                                alt="{{ $veiculo->marca . '/' . $veiculo->modelo }}">
                                        </div>
                                        <div class="thumb-content">
                                            <h4><a
                                                    href="/veiculos/{{ $veiculo->id }}">{{ $veiculo->marca . '/' . $veiculo->modelo }}</a>
                                            </h4>
                                            <div class="star-rating">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item"><i
                                                            class="fa fa-star{{ $stars >= 1 ? '' : '-o' }}"></i></li>
                                                    <li class="list-inline-item"><i
                                                            class="fa fa-star{{ $stars >= 2 ? '' : '-o' }}"></i></li>
                                                    <li class="list-inline-item"><i
                                                            class="fa fa-star{{ $stars >= 3 ? '' : '-o' }}"></i></li>
                                                    <li class="list-inline-item"><i
                                                            class="fa fa-star{{ $stars >= 4 ? '' : '-o' }}"></i></li>
                                                    <li class="list-inline-item"><i
                                                            class="fa fa-star{{ $stars >= 5 ? '' : '-o' }}"></i></li>
                                                </ul>
                                            </div>
                                            <p class="item-price">{{ $veiculo->ano . ' | ' . $veiculo->cor }} </p>
                                            @if (auth()->user() &&
                                                    auth()->user()->veiculosInteresse->contains($veiculo->id))
                                                <form action="/veiculos/leave/{{ $veiculo->id }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="/veiculos/leave/{{ $veiculo->id }}" id="event-submit"
                                                        class="botao"
                                                        onclick="event.preventDefault();this.closest('form').submit();">Tirar
                                                        Interesse</a>
                                                @else
                                                    <form action="/veiculos/join/{{ $veiculo->id }}" method="post">
                                                        @csrf
                                                        <a href="/veiculos/join/{{ $veiculo->id }}"
                                                            id="event-submit" class="btn btn-primary"
                                                            onclick="event.preventDefault();this.closest('form').submit();">Confirmar
                                                            Interesse</a>
                                                    </form>
                                            @endif
                                        </div>
                                </div>
                            </div>
    @endif
    @endforeach
    </div>
    </div>
    @if (count($veiculos) > 4)
        <div class="item carousel-item">
            <div class="row">
                @foreach ($veiculos as $veiculo)
                    @if ($loop->iteration > 4 && $loop->iteration <= 8)
                        <div class="col-sm-3">
                            <div class="thumb-wrapper">
                                <span class="wish-icon">
                                    @if (auth()->user() &&
                                            auth()->user()->veiculosInteresse->contains($veiculo->id))
                                        <form action="/veiculos/join/{{ $veiculo->id }}" method="post">
                                            @csrf
                                            <i class="fa fa-heart"
                                                onclick="event.preventDefault();this.closest('form').submit();"></i>
                                </span>
                                </form>
                            @else
                                <form action="/veiculos/join/{{ $veiculo->id }}" method="post">
                                    @csrf
                                    <i class="fa fa-heart-o"
                                        onclick="event.preventDefault();this.closest('form').submit();"></i>
                                </form>
                    @endif
                    </span>
                    <div class="img-box">
                        <img src="/img/veiculos/{{ $veiculo->foto }}" class="img-fluid"
                            alt="{{ $veiculo->marca . '/' . $veiculo->modelo }}">
                    </div>
                    <div class="thumb-content">
                        <h4>{{ $veiculo->marca . '/' . $veiculo->modelo }}</h4>
                        <div class="star-rating">
                            <ul class="list-inline">
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                            </ul>
                        </div>
                        <p class="item-price">{{ $veiculo->ano . ' | ' . $veiculo->cor }} </p>
                        <form action="/veiculos/join/{{ $veiculo->id }}" method="post">
                            @csrf
                            <a href="/veiculos/join/{{ $veiculo->id }}" id="event-submit" class="btn btn-primary"
                                onclick="event.preventDefault();this.closest('form').submit();">Confirmar Interesse</a>
                        </form>
                    </div>
            </div>
        </div>
    @endif
    @endforeach
    </div>
    </div>
    @endif
    @if (count($veiculos) > 8)
        <div class="item carousel-item">
            <div class="row">
                @foreach ($veiculos as $veiculo)
                    @if ($loop->iteration > 8)
                        <div class="col-sm-3">
                            <div class="thumb-wrapper">
                                <span class="wish-icon">
                                    @if (auth()->user() &&
                                            auth()->user()->veiculosInteresse->contains($veiculo->id))
                                        <form action="/veiculos/join/{{ $veiculo->id }}" method="post">
                                            @csrf
                                            <i class="fa fa-heart"
                                                onclick="event.preventDefault();this.closest('form').submit();"></i>
                                </span>
                                </form>
                            @else
                                <form action="/veiculos/join/{{ $veiculo->id }}" method="post">
                                    @csrf
                                    <i class="fa fa-heart-o"
                                        onclick="event.preventDefault();this.closest('form').submit();"></i>
                                </form>
                    @endif
                    </span>
                    <div class="img-box">
                        <img src="/img/veiculos/{{ $veiculo->foto }}" class="img-fluid"
                            alt="{{ $veiculo->marca . '/' . $veiculo->modelo }}">
                    </div>
                    <div class="thumb-content">
                        <h4>{{ $veiculo->marca . '/' . $veiculo->modelo }}</h4>
                        <div class="star-rating">
                            <ul class="list-inline">
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                            </ul>
                        </div>
                        <p class="item-price">{{ $veiculo->ano . ' | ' . $veiculo->cor }} </p>
                        <form action="/veiculos/join/{{ $veiculo->id }}" method="post">
                            @csrf
                            <a href="/veiculos/join/{{ $veiculo->id }}" id="event-submit" class="btn btn-primary"
                                onclick="event.preventDefault();this.closest('form').submit();">Confirmar Interesse</a>
                        </form>
                    </div>
            </div>
        </div>
    @endif
    @endforeach
    </div>
    </div>
    @endif
    </div>
    <!-- Carousel controls -->
    @if (count($veiculos) > 4)
        <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="carousel-control-next" href="#myCarousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
    @endif
    </div>
    </div>
    </div>
    </div>
    @endif
    @if (isset($search) && $veiculos->isEmpty())
        <div class="signup-form">
            <h2>Não localizamos nenhum resultado baseado em sua pesquisa: {{ $search }}</h2>
            <div class="text-center"><a href="/">Ver todos</a></div>
        </div>
    @endif

    <footer>
        <p>HD Veículos &copy; {{ date('Y') }}</p>
    </footer>
    <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
</body>

</html>
