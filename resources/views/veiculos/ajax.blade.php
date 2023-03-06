<div class="container-xl">
	<div class="row">
		<div class="col-md-10 mx-auto">
			<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
      @if (isset($search))
        <h2>Buscando por: <b>{{ $search }}</b></h2>
      @else
        <h2>Galeria <b>Ouro</b></h2>
      @endif
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
          $chunks = $veiculos->chunk(3);
        @endphp
        @foreach ($chunks as $chunk)
				<div class="carousel-item {{ $loop->first ? ' active' : '' }}">
					<div class="row">
            @foreach ($chunk as $veiculo)
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
                  @php
                    // Pegando apenas a primeira imagem
                    $fotos = json_decode($veiculo->fotos);
                    $primeiraFoto = array_shift($fotos);
                  @endphp
                    <div class="item">
                      <img src="{{ (filter_var($primeiraFoto, FILTER_VALIDATE_URL) !== false) ? $primeiraFoto : '/img/veiculos/'.$primeiraFoto }}" alt="{{ $veiculo->marca }}">
                    </div>
								</div>
								<div class="thumb-content">
									<h4>{{ $veiculo->marca . '/' . $veiculo->modelo }}</h4>
                  <p>{{ $veiculo->ano . ' | ' . $veiculo->cor }} </p>
                  <a href="/veiculos/{{ $veiculo->id }}" class="btn btn-primary">Ver detalhes<i class="fa fa-angle-right"></i></a>
								</div>						
							</div>
						</div>
            @endforeach		
					</div>
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
		</div>
	</div>
</div>