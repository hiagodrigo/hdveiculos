{{-- @if (Request::is('/'))
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12">
                @if (isset($search))
                    <h2>Buscando por: <b>{{ $search }}</b></h2>
                    @else
                    <h2>Galeria <b>Ouro</b></h2>
                @endif
                    <div class="carousel slide" data-interval="0" data-ride="carousel" id="myCarousel">
                        <!-- Carousel indicators -->
                        <ol class="carousel-indicators">
                        @php
                        //determinando quantidade de items retornado, para controlar quantidade de items do carousel
                        $numPaginas = ceil(count($veiculos) / 4);
                        @endphp
                        @if ($numPaginas <= 1)
                        <li class="active" data-slide-to="0" data-target="#myCarousel"></li>
                        @else
                        @for ($i = 0; $i < $numPaginas; $i++)
                        <li class="{{ $i == 0 ? 'active' : '' }}" data-slide-to="{{ $i }}" data-target="#myCarousel">
                        </li>
                        @endfor
                        @endif

                        </ol>
                    <!-- Wrapper for carousel items -->
                        <div class="carousel-inner">
                            @php
                                $chunks = $veiculos->chunk(4);
                            @endphp
                            @foreach ($chunks as $chunk)
                            <div class="item carousel-item {{ $loop->first ? ' active' : '' }}">
                                <div class="row">

                                    @foreach ($chunk as $veiculo)
                                        @php
                                            //gerando estrelas automaticamente, futuramente update para recuperar do banco
                                            $stars = rand(0, 5);
                                        @endphp
                                        <div class="col-sm-4">
                                            <div class="thumb-wrapper">
                                                <span class="wish-icon">
                                                @if (auth()->user() && auth()->user()->veiculosInteresse->contains($veiculo->id))
                                                    <form action="/veiculos/leave/{{ $veiculo->id }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <i class="fa fa-heart" onclick="event.preventDefault();this.closest('form').submit();"></i>
                                                    </span>
                                                    </form>
                                                @else
                                                    <form action="/veiculos/join/{{ $veiculo->id }}" method="post">
                                                    @csrf
                                                    <i class="fa fa-heart-o" onclick="event.preventDefault();this.closest('form').submit();"></i>
                                                    </form>
                                                @endif
                                                </span>
                                                <div class="img-box">
                                                    <img alt="{{ $veiculo->marca . '/' . $veiculo->modelo }}" class="img-fluid"
                                                    src="/img/veiculos/{{ $veiculo->foto }}">
                                                </div>
                                                <div class="thumb-content">
                                                    <h4><a href="/veiculos/{{ $veiculo->id }}">{{ $veiculo->marca . '/' . $veiculo->modelo }}</a>
                                                    </h4>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><i class="fa fa-star{{ $stars >= 1 ? '' : '-o' }}"></i></li>
                                                            <li class="list-inline-item"><i class="fa fa-star{{ $stars >= 2 ? '' : '-o' }}"></i></li>
                                                            <li class="list-inline-item"><i class="fa fa-star{{ $stars >= 3 ? '' : '-o' }}"></i></li>
                                                            <li class="list-inline-item"><i class="fa fa-star{{ $stars >= 4 ? '' : '-o' }}"></i></li>
                                                            <li class="list-inline-item"><i class="fa fa-star{{ $stars >= 5 ? '' : '-o' }}"></i></li>
                                                        </ul>
                                                    </div>
                                                    <p class="item-price">{{ $veiculo->ano . ' | ' . $veiculo->cor }} </p>
                                                    @if (auth()->user() && auth()->user()->veiculosInteresse->contains($veiculo->id))
                                                        <form action="/veiculos/leave/{{ $veiculo->id }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a class="botao" href="/veiculos/leave/{{ $veiculo->id }}" id="event-submit"
                                                        onclick="event.preventDefault();this.closest('form').submit();">Tirar
                                                        Interesse</a>
                                                    @else
                                                        <form action="/veiculos/join/{{ $veiculo->id }}" method="post">
                                                        @csrf
                                                        <a class="btn btn-primary" href="/veiculos/join/{{ $veiculo->id }}" id="event-submit"
                                                        onclick="event.preventDefault();this.closest('form').submit();">Confirmar
                                                        Interesse</a>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Carousel controls -->
                    <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                    {{-- <div class="pagination">
                        {{ $veiculos->onEachSide(1)->links('vendor.pagination.simple-default')  }}
                    </div> --}}
                    {{-- <div class="d-flex justify-content-center">
                        {{ $veiculos->links() }}
                    </div> --}}
            </div>
        </div>
    </div>
    </div>
@endif --}}