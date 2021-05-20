@extends('layout')

@section('body')

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<strong>Bem-vindo (a), {{ auth()->user()->name }}! </strong>
                
@endsection
