@extends('veiculos.index')

@section('title', 'Cadastro de veículos')

@section('content')

<div class="signup-form">	
    <form action="{{ route('veiculos.store') }}" method="post" enctype="multipart/form-data">
        @csrf
		<h2>Crie seu anúncio</h2>
		<p class="lead">É de graça e leva menos de 1 minuto!</p>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-car"></i></span>
				<input type="text" class="form-control" name="especie" placeholder="Espécie do veículo" required="required">
			</div>
        </div>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-motorcycle"></i></span>
				<input type="text" class="form-control" name="tipo" placeholder="Tipo do veículo" required="required">
			</div>
        </div>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-bus"></i></span>
				<input type="text" class="form-control" name="marca" placeholder="Marca do veículo" required="required">
			</div>
        </div>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-rocket"></i></span>
				<input type="text" class="form-control" name="modelo" placeholder="Modelo do veículo" required="required">
			</div>
        </div>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-pencil"></i></span>
				<input type="text" class="form-control" name="cor" placeholder="Cor do veículo" required="required">
			</div>
        </div>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-wrench"></i></span>
				<input type="text" class="form-control" name="potencia" placeholder="Potência do veículo" required="required">
			</div>
        </div>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				<input type="text" class="form-control" name="ano" placeholder="Ano do veículo" required="required">
			</div>
        </div>
        <div class="form-group" id="create">
			<div class="input-group">
                <p><span class="input-group-addon"><i class="fa fa-thumb-tack"></i></span>Opcionais:</p>  
                <div class="input-group">      
                <input type="checkbox" name="opcionais[]" value="Direção Hidráulica" class="checkbox"> Direção Hidráulica
                </div>
                <div class="input-group">
                <input type="checkbox" name="opcionais[]" value="Câmbio Automático" class="checkbox"> Câmbio Automático
                </div>
                <div class="input-group">
                <input type="checkbox" name="opcionais[]" value="Teto Solar" class="checkbox"> Teto Solar
                </div>
                <div class="input-group">
                <input type="checkbox" name="opcionais[]" value="Ar Condicionado" class="checkbox"> Ar Condicionado
                </div>
                <div class="input-group">	
                <input type="checkbox" name="opcionais[]" value="Roda de Liga Leve" class="checkbox"> Roda de Liga Leve
                </div>            
			</div>             
        </div>
		<div class="form-group" id="create">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-file-image-o"></i></span>
                <p>Insira a(s) foto(s)</p>
				<input type="file" name="fotos[]" id="fotos" multiple>
			</div>
        </div>       
		<div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-lg">Criar anúncio</button>
        </div>
    </form>
</div>

@endsection