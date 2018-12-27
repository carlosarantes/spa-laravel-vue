@extends('painel.template.template')

@section('conteudo')
	<div class="container">
		<table class="table table-stripped">
			<thead>
				<tr>
					<th>Nome</th>
					<th>CPF/CNPF</th>
				</tr>
			</thead>
			<tbody>
				@foreach($clientes as $cliente)
				<tr>
					<td>{{$cliente->nome}}</td>
					<td>{{$cliente->cpf_cnpj}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection



@if( auth()->check() )
@else
@endif