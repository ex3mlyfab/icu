<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"{{ !empty($htmlAttribute) ? $htmlAttribute : '' }}>

<head>
    @include('partial.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
