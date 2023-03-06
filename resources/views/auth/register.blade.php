@extends('veiculos.index')

@section('title', 'Criar conta')

@section('content')

<div class="signup-form">	
    <form action="{{ route('register') }}" method="post">
        @csrf
		<h2>Crie sua conta</h2>
		<p class="lead">É gratuito e não leva mais de 30 segundos.</p>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				<input type="text" class="form-control" id="name" name="name" :value="old('name')" placeholder="Digite seu nome" required autofocus autocomplete="name" />
			</div>
        </div>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
				<input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" :value="old('email')" required autocomplete="username" />
			</div>
        </div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<input type="password" class="form-control" name="password" placeholder="Digite sua Senha" required autocomplete="new-password" />
			</div>
        </div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-lock"></i>
					<i class="fa fa-check"></i>
				</span>
				<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirme sua senha" required autocomplete="new-password" />
			</div>
        </div>        
		<div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-lg">Cadastrar</button>
        </div>
    </form>
	<div class="text-center">Já tem uma conta? <a href="/login">entre aqui</a>.</div>
</div>

@endsection

     
