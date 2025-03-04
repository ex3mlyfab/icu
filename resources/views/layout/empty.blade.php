<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"{{ !empty($htmlAttribute) ? $htmlAttribute : '' }}>

<head>
    @include('partial.head')
    <meta http-equiv="refresh" content="{{ config('session.lifetime')*60 }}" >
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>

<body class="{{ !empty($bodyClass) ? $bodyClass : '' }}">
    <div class="toast-container sticky-top">
        <div class="toast fade hide mb-3" data-autohide="false" id="toast-1">
            <div class="toast-header">
                <i class="far fa-bell text-muted me-2"></i>
                <strong class="me-auto">Success!</strong>

                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">

            </div>
        </div>
    </div>
    @yield('content')

    @include('partial.scroll-top-btn')
    @include('partial.scripts')
</body>

</html>
