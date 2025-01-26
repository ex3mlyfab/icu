@extends('layout.default', [
    'appTopNav' => true,
	'appSidebarHide' => true,
	'appClass' => 'app-with-top-nav app-without-sidebar'
])

@section('title', 'Users List')

@push('css')
@include('partial.datatable.css')
@endpush

@push('js')
    @include('partial.datatable.js')
@endpush

@section('content')
    
@endsection