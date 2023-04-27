@extends('layout')
@section('title')
Importação Despesas
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('despesas.index') }}">Despesas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Importação</li>
    </ol>
</nav>
<div class='mb-2 d-flex justify-content-between'>
    <h3> Despesas </h3>
</div>
<form action="{{ route('importDespesas') }}" method='POST' enctype="multipart/form-data">
    @method('POST')
    @csrf
    <div class="form-group">
        <input type="file" name="importacao" id="importacao" >
    </div>
    <button class='btn btn-success' type="submit">Enviar</button>
</form>

@endsection
@section('script')
<script>
    @if(Session::has('message'))
        toastr["success"]("{{ Session::get('message') }}")
    @endif
</script>
@endsection
