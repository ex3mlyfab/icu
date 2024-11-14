@extends('layout.default', [
  'appSidebarHide' => true,
  'appClass' => 'app-content-full-width'
])

@section('title', 'testing greaat')

@push('css')

@endpush

@push('js')
<script src="/assets/plugins/apexcharts/dist/apexcharts.min.js"></script>
<script src="/assets/js/demo/dashboard.demo.js"></script>
@endpush

@section('content')
<div class="container">
    <div class="card h-100">
        <div class="card-head">Testing Chart</div>
        <div class="card-body bg-transparent">
        <div id="chart"></div>
        </div>
    </div>
</div>
@endsection
