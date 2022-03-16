@extends('layouts.app')
{{-- Aqui no blade, tem acesso a recursos php --}}
{{-- Aqui tem acessos aos helpers do laravel --}}
{{-- Aqui pode recuperar variáveis que são encaminhas dos controllers para as views --}}
@section('content')
    {{-- Instância do componente "Login.vue" --}}
    {{-- Enviando as "props" daqui, para o componente vue --}}
    <login-component token_csrf="{{ @csrf_token() }}"></login-component>
@endsection
