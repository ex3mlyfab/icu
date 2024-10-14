<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"{{ (!empty($htmlAttribute)) ? $htmlAttribute : '' }}>
<head>
	@include('partial.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="{{ (!empty($bodyClass)) ? $bodyClass : '' }}">
	@yield('content')

	@include('partial.scroll-top-btn')
	
	@include('partial.scripts')
</body>
</html>
