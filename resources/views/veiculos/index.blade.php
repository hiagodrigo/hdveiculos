<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
	<title>
		@yield('title', 'HD Veículos')
	</title>

    {{-- Fonts --}}
	<link href="https://fonts.googleapis.com/css?family=Roboto|Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Merienda+One" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    {{-- Bootstrap --}}
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	
	<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
	
    {{-- Scripts personalizados --}}
	<link href="/css/styles.css" rel="stylesheet" type="text/css">
	<script src="/js/app.js"></script>
</head>

<body>
	<nav class="navbar navbar-expand-xl navbar-light bg-light">
		<a class="navbar-brand" href="/"><img alt="HD Veículos" src="/img/logo.png"></a>
		<button class="navbar-toggler" data-target="#navbarCollapse" data-toggle="collapse" type="button">
			<span class="navbar-toggler-icon"></span>
		</button>
		<!-- Collection of nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse justify-content-start" id="navbarCollapse">
			<div class="navbar-nav">
				<a class="nav-item nav-link active" href="/">Home</a>
				<a class="nav-item nav-link" href="/veiculos/create">Crie seu anúncio</a>
				<div class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Veículos</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="/?search=passageiro">Passageiro</a>
						<a class="dropdown-item" href="/?search=carga">Carga</a>
						<a class="dropdown-item" href="/?search=cambio automatico">Câmbio Automático</a>
						<a class="dropdown-item" href="/?search=Camionetas">Camionetas</a>
					</div>
				</div>
			</div>
			<form class="navbar-form form-inline">
				<div class="input-group search-box">
					<form action="/" method="get">
						<input class="form-control" id="search" name="search" placeholder="Procurar" type="text">
						<span class="input-group-addon"><i class="material-icons">&#xE8B6;</i></span>
					</form>
				</div>
			</form>
			@auth
				<div class="navbar-nav ml-auto">
					<div class="nav-item dropdown">
						<a class="nav-link dropdown-toggle user-action" data-bs-toggle="dropdown" href="#">
							{{ auth()->user()->name }} <b class="caret"></b></a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="/dashboard"><i class="fa fa-user-o"></i> Meus anúncios</a></a>
							<a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fa fa-sliders"></i>Meus dados</a></a>
							<div class="dropdown-divider"></div>
							<form action="/logout" method="POST">
								@csrf
								<a class="dropdown-item" href="/logout" onclick="event.preventDefault(); this.closest('form').submit();"><i class="material-icons">&#xE8AC;</i> Logout</a></a>
							</form>
						</div>
					</div>
				</div>
			@endauth
			@guest
				<div class="navbar-nav ml-auto">
					<div class="navbar-nav">
						<a class="nav-item nav-link" href="/login">Entrar</a>
						<a class="nav-item nav-link" href="/register">Cadastrar</a>
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

		@if(Request::is('/'))
			@if($veiculos->isEmpty())
				<div class="signup-form">
					<h2>Ainda não temos nenhum veículo cadastrado, que tal <a href="/veiculos/create"> cadastrar agora?</a></h2>
				</div>				
			@else
        		@include('veiculos.ajax')
			
			@endif
    	@endif

		@yield('content')
	</main>

    

	@if (isset($search) && $veiculos->isEmpty())
		<div class="signup-form">
			<h2>Não localizamos nenhum resultado baseado em sua pesquisa: {{ $search }}</h2>
			<div class="text-center"><a href="/">Ver todos</a></div>
		</div>
	@endif

	<footer>
		<p>HD Veículos &copy; {{ date('Y') }}</p>
	</footer>

    {{-- Ion icons --}}
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

	{{-- Bootstrap Script --}}
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
	
</body>

</html>
