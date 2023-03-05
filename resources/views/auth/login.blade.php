@extends('veiculos.index')

@section('title', 'Login')

@section('content')

<div class="signup-form">	
    @if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
    @endif
    <form action="{{ route('login') }}" method="post">
        @csrf
		<h2>Entre em sua conta</h2>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				<input type="text" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" :value="old('email')" required autofocus autocomplete="username">
			</div>
        </div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha" required autocomplete="current-password">
			</div>
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="flex items-center">
                <x-checkbox id="remember_me" name="remember" />
                <span class="ml-2 text-sm text-gray-600">{{ __('Manter conectado') }}</span>
            </label>
        </div>
        
		<div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-lg">Entrar</button>
        </div>
    </form>
	<div class="text-center">Ainda não tem sua conta <a href="/register">cadastre agora</a>.</div>
</div>

@endsection

        

